<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BusinessMatchingBooking extends Model
{
    protected $fillable = [
        'business_matching_id',
        'time_slot_id',
        'user_id',
        'participant_name',
        'participant_email',
        'participant_phone',
        'company_name',
        'business_type',
        'interests',
        'notes'
    ];

    protected $casts = [
        'interests' => 'array'
    ];


    /**
     * Get the business matching that owns the booking.
     */
    public function businessMatching(): BelongsTo
    {
        return $this->belongsTo(BusinessMatching::class);
    }


    /**
     * Get the time slot for this booking.
     */
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(BusinessMatchingTimeSlot::class, 'time_slot_id');
    }

    /**
     * Get the user that made the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the formatted interests as a string.
     */
    public function getFormattedInterests(): string
    {
        if (empty($this->interests)) {
            return 'None specified';
        }
        
        return is_array($this->interests) ? implode(', ', $this->interests) : $this->interests;
    }

    /**
     * Get the booking reference number.
     */
    public function getReferenceNumber(): string
    {
        return 'BM' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

}
