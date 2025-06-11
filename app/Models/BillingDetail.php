<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'category',
        'country',
        'address1',
        'address2',
        'city',
        'state',
        'postcode',
        'phone',
        'email',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
} 