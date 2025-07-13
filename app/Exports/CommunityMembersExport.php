<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommunityMembersExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return User::query()
            ->where('role', 'client')
            ->with('profile');
    }

    public function headings(): array
    {
        return [
            // User table fields
            'ID',
            'Name',
            'Email',
            'Email Verified',
            'Created At',
            'Updated At',
            'Google ID',
            'Avatar',

            // Profile fields - Basic Info
            'Title',
            'First Name',
            'Last Name',
            'Category',
            'About Me',

            // Contact Information
            'Mobile Number',
            'Address',
            'City',
            'State',
            'Postal Code',
            'Country',

            // Academic Information
            'Student ID',
            'Academic Institution',

            // Professional Information
            'Job Title',
            'Organization',
            'Nature of Business',
            'Green Card',
            'Impact Number',

            // Social Media
            'Website',
            'LinkedIn',
            'Facebook',
            'Twitter',
            'Instagram'
        ];
    }

    public function map($user): array
    {
        return [
            // User table fields
            $user->id,
            $user->name,
            $user->email,
            $user->email_verified_at ? 'Yes' : 'No',
            $user->created_at->format('d M Y H:i'),
            $user->updated_at->format('d M Y H:i'),
            $user->google_id ?? '-',
            $user->avatar ?? '-',

            // Profile fields - Basic Info
            $user->profile->title ?? '-',
            $user->profile->first_name ?? '-',
            $user->profile->last_name ?? '-',
            $user->profile->category ?? '-',
            $user->profile->about_me ?? '-',

            // Contact Information
            $user->profile->mobile_number ?? '-',
            $user->profile->address ?? '-',
            $user->profile->city ?? '-',
            $user->profile->state ?? '-',
            $user->profile->postal_code ?? '-',
            $user->profile->country ?? '-',

            // Academic Information
            $user->profile->student_id ?? '-',
            $user->profile->academic_institution ?? '-',

            // Professional Information
            $user->profile->job_title ?? '-',
            $user->profile->organization ?? '-',
            $user->profile->nature_of_business ?? '-',
            $user->profile->green_card ?? '-',
            $user->profile->impact_number ?? '-',

            // Social Media
            $user->profile->website ?? '-',
            $user->profile->linkedin ?? '-',
            $user->profile->facebook ?? '-',
            $user->profile->twitter ?? '-',
            $user->profile->instagram ?? '-'
        ];
    }
} 