<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'billing_detail_id',
        'reference_number',
        'total_amount',
        'status',
        'cart_items',
        'payment_id',
        'payment_method',
        'payment_country',
        'processing_fee'
    ];

    protected $casts = [
        'cart_items' => 'array',
        'total_amount' => 'decimal:2',
        'processing_fee' => 'decimal:2'
    ];

    public function billingDetail()
    {
        return $this->belongsTo(BillingDetail::class);
    }
} 