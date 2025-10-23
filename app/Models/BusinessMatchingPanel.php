<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessMatchingPanel extends Model
{
    protected $fillable = [
        'business_matching_id',
        'name',
        'description',
        'image',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get the business matching that owns the panel.
     */
    public function businessMatching(): BelongsTo
    {
        return $this->belongsTo(BusinessMatching::class);
    }



}
