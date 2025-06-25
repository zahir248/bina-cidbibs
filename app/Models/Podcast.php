<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $fillable = [
        'type',
        'episode_number',
        'title',
        'description',
        'image',
        'youtube_url',
        'panelists',
        'is_live_streaming',
        'live_streaming_event',
        'is_coming_soon',
        'display_order',
        'is_active',
        'is_special',
        'special_position'
    ];

    protected $casts = [
        'panelists' => 'array',
        'is_live_streaming' => 'boolean',
        'is_coming_soon' => 'boolean',
        'is_active' => 'boolean',
        'is_special' => 'boolean',
        'display_order' => 'integer'
    ];

    // Scope for BINA podcasts
    public function scopeBina($query)
    {
        return collect($query->where('type', 'bina')
            ->where('is_active', true)
            ->get()
            ->sortBy(function($podcast) {
                if ($podcast->is_special) {
                    // Find the target episode
                    $targetEpisode = self::where('type', $podcast->type)
                        ->where('episode_number', $podcast->episode_number)
                        ->where('is_special', false)
                        ->first();
                    
                    if ($targetEpisode) {
                        $baseOrder = intval($targetEpisode->episode_number) * 100;
                        return $podcast->special_position === 'above' 
                            ? $baseOrder - 1 
                            : $baseOrder + 1;
                    }
                }
                return intval($podcast->episode_number) * 100;
            })
            ->values());
    }

    // Scope for FM podcasts
    public function scopeFm($query)
    {
        return collect($query->where('type', 'fm')
            ->where('is_active', true)
            ->get()
            ->sortBy(function($podcast) {
                if ($podcast->is_special) {
                    // Find the target episode
                    $targetEpisode = self::where('type', $podcast->type)
                        ->where('episode_number', $podcast->episode_number)
                        ->where('is_special', false)
                        ->first();
                    
                    if ($targetEpisode) {
                        $baseOrder = intval($targetEpisode->episode_number) * 100;
                        return $podcast->special_position === 'above' 
                            ? $baseOrder - 1 
                            : $baseOrder + 1;
                    }
                }
                return intval($podcast->episode_number) * 100;
            })
            ->values());
    }

    /**
     * Get the properly formatted title with styling
     */
    public function getFormattedTitleAttribute()
    {
        if (str_contains($this->title, ':')) {
            $parts = explode(':', $this->title, 2);
            return '<div style="font-weight:600;">' . $parts[0] . '</div>' .
                   '<div style="font-style:italic;margin-top:0.25rem;">' . trim($parts[1]) . '</div>';
        }
        return '<div style="font-style:italic;">' . $this->title . '</div>';
    }

    /**
     * Get the properly formatted image URL
     */
    public function getFormattedImageUrlAttribute()
    {
        if (empty($this->image)) {
            return null;
        }

        // Check if it's a Google Drive file link
        if (str_contains($this->image, 'drive.google.com')) {
            // Extract the file ID from various Google Drive URL formats
            if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $this->image, $matches)) {
                $fileId = $matches[1];
                // Return the direct download URL for full quality
                return 'https://lh3.googleusercontent.com/d/' . $fileId;
            }
        }

        // If it's already in the correct format or it's another type of URL, return as is
        return $this->image;
    }
} 