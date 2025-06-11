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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('client.profile'));
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
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'client',
            ]);

            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please complete your profile details.',
                'redirect' => route('client.user.details')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration. Please try again.'
            ], 500);
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

                Auth::login($user);
                session()->forget('google_registration');
                return redirect()->route('client.profile');
            } else {
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
                
                Auth::login($user);
                return redirect()->route('client.profile');
            }

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

    public function userDetails()
    {
        if (Auth::user()->profile) {
            return redirect()->route('client.profile');
        }
        return view('client.auth.user-details');
    }

    public function updateUserDetails(Request $request)
    {
        try {
            $validator = validator($request->all(), [
                'category' => ['nullable', 'string', 'in:individual,academician,organization'],
                'mobile_number' => ['nullable', 'regex:/^[0-9]+$/', 'max:15'],
                'student_id' => ['nullable', 'string'],
                'academic_institution' => ['nullable', 'string'],
                'job_title' => ['nullable', 'string'],
                'organization' => ['nullable', 'string'],
                'green_card' => ['nullable', 'string'],
                'impact_number' => ['nullable', 'string'],
                'title' => ['nullable', 'string'],
                'first_name' => ['nullable', 'string', 'max:255'],
                'last_name' => ['nullable', 'string', 'max:255'],
                'about_me' => ['nullable', 'string'],
                'address' => ['nullable', 'string', 'max:500'],
                'city' => ['nullable', 'string', 'max:255'],
                'state' => ['nullable', 'string', 'max:255'],
                'postal_code' => ['nullable', 'regex:/^[0-9]+$/', 'max:10'],
                'country' => ['nullable', 'string', 'max:255'],
                'website' => ['nullable', 'string', 'max:255'],
                'linkedin' => ['nullable', 'string', 'max:255'],
                'facebook' => ['nullable', 'string', 'max:255'],
                'twitter' => ['nullable', 'string', 'max:255'],
                'instagram' => ['nullable', 'string', 'max:255']
            ], [
                'mobile_number.regex' => 'Mobile number must contain numbers only.',
                'postal_code.regex' => 'Postal code must contain numbers only.'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = Auth::user();
            
            // Get all fields that can be updated
            $fields = [
                'category',
                'mobile_number',
                'student_id',
                'academic_institution',
                'job_title',
                'organization',
                'green_card',
                'impact_number',
                'title',
                'first_name',
                'last_name',
                'about_me',
                'address',
                'city',
                'state',
                'postal_code',
                'country',
                'website',
                'linkedin',
                'facebook',
                'twitter',
                'instagram'
            ];

            // Prepare the data for update, converting empty strings to null
            $profileData = [];
            foreach ($fields as $field) {
                $profileData[$field] = $request->input($field) === '' ? null : $request->input($field);
            }

            // Create or update user profile
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            return redirect()->route('client.profile')
                ->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Profile Update Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->with('error', 'An error occurred while updating your profile. Please try again.')
                ->withInput();
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