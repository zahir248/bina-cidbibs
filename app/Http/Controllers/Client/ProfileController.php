<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        // Get the authenticated user's profile
        $user = Auth::user();
        $profile = $user->profile;

        // Get recommended profiles based on user's preferences
        $profiles = UserProfile::with('user')
            ->where('user_id', '!=', Auth::id())
            ->when(request('keywords'), function($query) {
                $keywords = request('keywords');
                return $query->where(function($q) use ($keywords) {
                    $q->where('about_me', 'like', "%{$keywords}%")
                      ->orWhere('organization', 'like', "%{$keywords}%")
                      ->orWhere('academic_institution', 'like', "%{$keywords}%")
                      ->orWhere('job_title', 'like', "%{$keywords}%");
                });
            })
            ->when(request('location'), function($query) {
                $location = request('location');
                return $query->where(function($q) use ($location) {
                    $q->where('city', 'like', "%{$location}%")
                      ->orWhere('state', 'like', "%{$location}%")
                      ->orWhere('country', 'like', "%{$location}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('client.profile.index', compact('profiles', 'profile'));
    }

    public function search(Request $request)
    {
        return $this->index();
    }

    public function saveProfile(Request $request, $profileId)
    {
        // Add logic to save profile
        return response()->json(['success' => true]);
    }

    public function removeProfile(Request $request, $profileId)
    {
        // Add logic to remove profile from recommendations
        return response()->json(['success' => true]);
    }

    public function savedProfiles()
    {
        // Get user's saved profiles
        $savedProfiles = []; // Add logic to get saved profiles
        return view('client.profile.saved', compact('savedProfiles'));
    }

    public function savedSearches()
    {
        // Get user's saved searches
        $savedSearches = []; // Add logic to get saved searches
        return view('client.profile.searches', compact('savedSearches'));
    }

    public function updateAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $user = Auth::user();

            // Delete old avatar if exists and is not an external URL
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                $oldFilename = basename($user->avatar);
                Storage::disk('public')->delete('avatars/' . $oldFilename);
            }

            // Store new avatar in storage/app/public/avatars
            $file = $request->file('avatar');
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Ensure the avatars directory exists
            Storage::disk('public')->makeDirectory('avatars');
            
            // Store the file
            $path = $file->storeAs('avatars', $fileName, 'public');
            
            // Update user's avatar path - store just the filename
            $user->update(['avatar' => $fileName]);

            return redirect()->back()->with('success', 'Profile photo updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Avatar Update Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to update profile photo. ' . $e->getMessage());
        }
    }

    public function removeAvatar(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Delete the old avatar file if it exists and is not an external URL
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            
            // Remove the avatar path from the user record
            $user->update(['avatar' => null]);
            
            return back()->with('success', 'Profile photo removed successfully.');
        } catch (\Exception $e) {
            \Log::error('Avatar Remove Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to remove profile photo. Please try again.');
        }
    }

    public function update(Request $request)
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
                ->with('success', 'Profile updated successfully!')
                ->with('scroll_to_content', true);

        } catch (\Exception $e) {
            \Log::error('Profile Update Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('client.profile')
                ->with('error', 'An error occurred while updating your profile. Please try again.')
                ->withInput()
                ->with('scroll_to_content', true);
        }
    }

    public function clearReminder()
    {
        session()->forget('show_profile_reminder');
        return response()->json(['success' => true]);
    }
} 