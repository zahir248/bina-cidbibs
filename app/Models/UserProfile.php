<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 