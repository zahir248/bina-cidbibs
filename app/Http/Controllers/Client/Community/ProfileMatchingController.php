<?php

namespace App\Http\Controllers\Client\Community;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileMatchingController extends Controller
{
    /**
     * Display the profile matching page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'client')
            ->where('id', '!=', auth()->id()) // Exclude current user
            ->with('profile');  // Eager load the profile relationship

        // Apply filters only if the user has a profile
        if ($request->filled('location') || $request->filled('nature_of_business')) {
            $query->whereHas('profile', function($query) use ($request) {
                // Apply country filter if provided
                if ($request->filled('location')) {
                    $query->where('country', $request->location);
                }

                // Apply nature of business filter if provided
                if ($request->filled('nature_of_business')) {
                    $query->where('nature_of_business', $request->nature_of_business);
                }
            });
        }

        $users = $query->get()
            ->map(function ($user) {
                // If user has no profile, return minimal data
                if (!$user->profile) {
                    return [
                        'id' => $user->id,
                        'full_name' => $user->name,
                        'email' => $user->email,
                        'job_title' => 'Not provided',
                        'about_me' => 'No description available',
                        'avatar' => $user->avatar 
                        ? (filter_var($user->avatar, FILTER_VALIDATE_URL) 
                            ? $user->avatar // If it's already a URL (e.g. Google avatar)
                            : route('avatar.show', $user->avatar)) // If it's a local file
                        : 'https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg',
                        'category' => 'Not provided',
                        'mobile_number' => 'Not provided',
                        'student_id' => 'Not provided',
                        'academic_institution' => 'Not provided',
                        'organization' => 'Not provided',
                        'nature_of_business' => 'Not provided',
                        'green_card' => 'Not provided',
                        'impact_number' => 'Not provided',
                        'address' => 'Not provided',
                        'city' => 'Not provided',
                        'state' => 'Not provided',
                        'postal_code' => 'Not provided',
                        'country' => 'Not provided',
                        'website' => 'Not provided',
                        'linkedin' => 'Not provided',
                        'facebook' => 'Not provided',
                        'twitter' => 'Not provided',
                        'instagram' => 'Not provided'
                    ];
                }

                // For users with profile, return full data
                return [
                    'id' => $user->id,
                    'full_name' => $user->profile->first_name . ' ' . $user->profile->last_name,
                    'email' => $user->email,
                    'job_title' => $user->profile->job_title,
                    'about_me' => $user->profile->about_me,
                    'avatar' => $user->avatar 
                        ? (filter_var($user->avatar, FILTER_VALIDATE_URL) 
                            ? $user->avatar // If it's already a URL (e.g. Google avatar)
                            : route('avatar.show', $user->avatar)) // If it's a local file
                        : 'https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg',
                    'category' => $user->profile->category,
                    'mobile_number' => $user->profile->mobile_number,
                    'student_id' => $user->profile->student_id,
                    'academic_institution' => $user->profile->academic_institution,
                    'organization' => $user->profile->organization,
                    'nature_of_business' => $user->profile->nature_of_business,
                    'green_card' => $user->profile->green_card,
                    'impact_number' => $user->profile->impact_number,
                    'address' => $user->profile->address,
                    'city' => $user->profile->city,
                    'state' => $user->profile->state,
                    'postal_code' => $user->profile->postal_code,
                    'country' => $user->profile->country,
                    'website' => $user->profile->website,
                    'linkedin' => $user->profile->linkedin,
                    'facebook' => $user->profile->facebook,
                    'twitter' => $user->profile->twitter,
                    'instagram' => $user->profile->instagram
                ];
            });

        return view('client.community.profile-matching.index', compact('users'));
    }
}
