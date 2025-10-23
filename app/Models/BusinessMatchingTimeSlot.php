<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessMatchingTimeSlot extends Model
{
    protected $fillable = [
        'business_matching_id',
        'start_time',
        'end_time',
        'order',
        'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get the business matching that owns the time slot.
     */
    public function businessMatching(): BelongsTo
    {
        return $this->belongsTo(BusinessMatching::class);
    }

    /**
     * Get the bookings for this time slot.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(BusinessMatchingBooking::class, 'time_slot_id');
    }

    /**
     * Get the panels available for this time slot.
     */
    public function panels()
    {
        return $this->businessMatching->panels();
    }

    /**
     * Get the current number of participants in this time slot.
     */
    public function getCurrentParticipantsCount(): int
    {
        return $this->bookings()->count();
    }

    /**
     * Check if the time slot is full.
     */
    public function isFull(): bool
    {
        // Max 3 people per time slot
        return $this->getCurrentParticipantsCount() >= 3;
    }

    /**
     * Get the formatted time range.
     */
    public function getFormattedTimeRange(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    /**
     * Check if the time slot is currently active.
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();
        return $this->start_time <= $now && $this->end_time >= $now;
    }

    /**
     * Check if the time slot has passed.
     */
    public function hasPassed(): bool
    {
        return $this->end_time < now();
    }
}
