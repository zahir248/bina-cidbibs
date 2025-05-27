<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'ticket_id',
        'quantity',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
} 