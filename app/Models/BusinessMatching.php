<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessMatching extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'date',
        'start_time',
        'end_time',
        'is_active'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Get the event that owns the business matching.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the panels for this business matching.
     */
    public function panels(): HasMany
    {
        return $this->hasMany(BusinessMatchingPanel::class)->orderBy('order');
    }

    /**
     * Get the bookings for this business matching.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(BusinessMatchingBooking::class);
    }

    /**
     * Get the time slots for this business matching.
     */
    public function timeSlots(): HasMany
    {
        return $this->hasMany(BusinessMatchingTimeSlot::class)->orderBy('order');
    }

    /**
     * Check if the business matching is currently open for registration.
     */
    public function isOpenForRegistration(): bool
    {
        return $this->is_active && 
               $this->date >= now()->toDateString();
    }


    /**
     * Get the total number of participants across all panels.
     */
    public function getTotalParticipants(): int
    {
        return $this->bookings()->count();
    }

    /**
     * Get the capacity utilization percentage.
     */
    public function getCapacityUtilization(): float
    {
        $totalCapacity = $this->timeSlots()->count() * 2; // 2 people per time slot
        if ($totalCapacity == 0) {
            return 0;
        }
        
        return ($this->getTotalParticipants() / $totalCapacity) * 100;
    }
}
