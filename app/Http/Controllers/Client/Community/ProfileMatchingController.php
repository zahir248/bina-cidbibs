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
    public function index()
    {
        $users = User::where('role', 'client')
            ->where('id', '!=', auth()->id()) // Exclude current user
            ->with('profile')  // Eager load the profile relationship
            ->whereHas('profile')  // Only get users that have profiles
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'full_name' => $user->profile->first_name . ' ' . $user->profile->last_name,
                    'email' => $user->email,
                    'job_title' => $user->profile->job_title,
                    'about_me' => $user->profile->about_me,
                    'avatar' => $user->avatar 
                        ? asset('storage/avatars/' . $user->avatar) 
                        : 'https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg',
                    // Additional profile information
                    'category' => $user->profile->category,
                    'mobile_number' => $user->profile->mobile_number,
                    'student_id' => $user->profile->student_id,
                    'academic_institution' => $user->profile->academic_institution,
                    'organization' => $user->profile->organization,
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
