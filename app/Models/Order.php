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
        'payment_status',
        'cart_items'
    ];

    protected $casts = [
        'cart_items' => 'array',
        'total_amount' => 'decimal:2'
    ];

    public function billingDetail()
    {
        return $this->belongsTo(BillingDetail::class);
    }
} 