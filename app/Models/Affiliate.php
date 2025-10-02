<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Affiliate extends Model
{
    protected $fillable = [
        'user_id',
        'affiliate_code',
        'name',
        'description',
        'is_active',
        'total_clicks',
        'total_conversions'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'total_clicks' => 'integer',
        'total_conversions' => 'integer'
    ];

    /**
     * Get the user that owns the affiliate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the orders associated with this affiliate.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Generate a unique affiliate code.
     */
    public static function generateAffiliateCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('affiliate_code', $code)->exists());

        return $code;
    }

    /**
     * Get the affiliate link.
     */
    public function getAffiliateLinkAttribute(): string
    {
        return url('/?ref=' . $this->affiliate_code);
    }

    /**
     * Increment click count.
     */
    public function incrementClicks(): void
    {
        $this->increment('total_clicks');
    }

    /**
     * Increment conversion count.
     */
    public function addConversion(): void
    {
        $this->increment('total_conversions');
    }
}
