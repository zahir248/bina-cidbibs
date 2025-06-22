<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('client.auth.login');
    }

    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('client.community');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records. Please register first.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('client.auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validator = validator($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
                ],
            ], [
                'name.required' => 'Please enter your full name.',
                'name.max' => 'Your name cannot exceed 255 characters.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered. Please use a different email.',
                'password.required' => 'Please enter a password.',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'client',
            ]);

            Auth::login($user);
            
            // Set session flag to show profile reminder
            session(['show_profile_reminder' => true]);

            return redirect()->route('client.profile')
                ->with('success', 'Registration successful! You can now update your profile.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred during registration. Please try again.')
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('client.home'));
    }

    // Social Login Methods
    public function redirectToGoogle()
    {
        try {
            // Set registration flag if coming from registration page
            if (url()->previous() === route('client.register')) {
                session(['google_registration' => true]);
            } else {
                session()->forget('google_registration');
            }

            $guzzleConfig = [
                'verify' => base_path('cacert.pem'),
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => true
                ]
            ];

            return Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client($guzzleConfig))
                ->with([
                    'prompt' => 'select_account',
                    'access_type' => 'offline',
                    'response_type' => 'code'
                ])
                ->redirect();
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('client.login')
                ->with('error', 'Unable to connect to Google. Please try again later.');
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $guzzleConfig = [
                'verify' => base_path('cacert.pem'),
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => true
                ]
            ];

            $googleUser = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client($guzzleConfig))
                ->user();
            
            \Log::info('Google User Data:', [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar
            ]);

            // Check if we're in registration flow
            $isRegistering = session('google_registration', false);
            
            // Find user by email or google_id
            $user = User::where('email', $googleUser->email)
                       ->orWhere('google_id', $googleUser->id)
                       ->first();

            if ($isRegistering) {
                // Registration Flow
                if ($user) {
                    return redirect()->route('client.login')
                        ->with('error', 'This email is already registered. Please login instead.');
                }

                // Create new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'client',
                    'email_verified_at' => now()
                ]);

                Auth::login($user, true);
                session()->forget('google_registration');
                // Set session flag to show profile reminder and redirect to profile page
                session(['show_profile_reminder' => true]);
                return redirect()->route('client.profile')->with('success', 'Registration successful! You can now update your profile.');
            }
            
            // Login Flow
            if (!$user) {
                return redirect()->route('client.register')
                    ->with('error', 'Account not found. Please register first.');
            }

            // Update google_id if not set
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar
                ]);
            }
            
            Auth::login($user, true);
            return redirect()->route('client.community');

        } catch (\Exception $e) {
            \Log::error('Google Callback Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Unable to login with Google. ';
            if (app()->environment('local')) {
                $errorMessage .= $e->getMessage();
            } else {
                $errorMessage .= 'Please try again later.';
            }

            return redirect()->route('client.login')
                ->with('error', $errorMessage);
        }
    }

    public function completeGoogleAuth()
    {
        $userId = session('google_auth_user');
        
        if (!$userId) {
            return redirect()->route('register')
                ->with('error', 'Authentication session expired. Please try again.');
        }

        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('register')
                ->with('error', 'User not found. Please try again.');
        }

        Auth::login($user);
        session()->forget('google_auth_user');
        
        return redirect()->route('client.profile');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended(route('client.profile'));
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => Hash::make(rand(1,1000000)), // random password
                ]);

                Auth::login($newUser);
                return redirect()->intended(route('client.profile'));
            }
        } catch (\Exception $e) {
            return redirect()->route('client.login')->with('error', 'Something went wrong with Facebook login');
        }
    }

    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function handleLinkedinCallback()
    {
        try {
            $user = Socialite::driver('linkedin')->user();
            $finduser = User::where('linkedin_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended(route('client.profile'));
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'linkedin_id' => $user->id,
                    'password' => Hash::make(rand(1,1000000)), // random password
                ]);

                Auth::login($newUser);
                return redirect()->intended(route('client.profile'));
            }
        } catch (\Exception $e) {
            return redirect()->route('client.login')->with('error', 'Something went wrong with LinkedIn login');
        }
    }

    public function updateAvatar(Request $request)
    {
        try {
            $user = Auth::user();
            
            // If avatar is a URL (e.g. from Google)
            if ($request->has('avatar_url')) {
                // Delete the old avatar file if it exists and is a local file
                if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                    $oldPath = public_path($user->avatar);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                
                // Update with new URL
                $user->update(['avatar' => $request->avatar_url]);
                return back()->with('success', 'Profile photo updated successfully.');
            }
            
            // Validate uploaded file
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Delete the old avatar file if it exists and is a local file
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                $oldPath = public_path($user->avatar);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Store new avatar directly in public directory
            $file = $request->file('avatar');
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $avatarPath = 'uploads/avatars/' . $fileName;
            
            // Create directory if it doesn't exist
            $directory = public_path('uploads/avatars');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Move the file to public directory
            $file->move($directory, $fileName);
            
            // Save the relative path in database
            $user->update(['avatar' => $avatarPath]);
            
            return back()->with('success', 'Profile photo updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update profile photo. Please try again.');
        }
    }

    public function removeAvatar(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Delete the old avatar file if it exists and is a local file
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                $oldPath = public_path($user->avatar);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Remove the avatar path from the user record
            $user->update(['avatar' => null]);
            
            return back()->with('success', 'Profile photo removed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove profile photo. Please try again.');
        }
    }

    public function deactivateAccount(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Delete user's profile if exists
            if ($user->profile) {
                $user->profile->delete();
            }
            
            // Delete user's avatar if exists
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                $oldPath = public_path($user->avatar);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Delete the user
            $user->delete();
            
            // Logout
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('client.home')
                ->with('success', 'Your account has been successfully deactivated.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to deactivate account. Please try again.');
        }
    }
} 