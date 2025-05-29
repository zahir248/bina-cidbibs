<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'session',
        'event_type'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function getFormattedTimeAttribute()
    {
        $start = $this->start_time ? $this->start_time->format('h:i A') : '';
        $end = $this->end_time ? $this->end_time->format('h:i A') : '';
        return $end ? ($start . ' - ' . $end) : $start;
    }
} 