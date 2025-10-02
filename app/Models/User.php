<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\UserProfile;
use App\Models\ConnectionRequest;
use App\Models\Message;
use App\Models\CartItem;
use App\Models\BillingDetail;
use App\Models\Affiliate;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
        'google_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's profile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the connection requests sent by the user.
     */
    public function connectionRequestsSent()
    {
        return $this->hasMany(ConnectionRequest::class, 'sender_id');
    }

    /**
     * Get the connection requests received by the user.
     */
    public function connectionRequestsReceived()
    {
        return $this->hasMany(ConnectionRequest::class, 'receiver_id');
    }

    /**
     * Get the messages sent by the user.
     */
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the messages received by the user.
     */
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get the user's cart items.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the user's billing details.
     */
    public function billingDetails()
    {
        return $this->hasMany(BillingDetail::class);
    }

    /**
     * Get the user's affiliate links.
     */
    public function affiliates()
    {
        return $this->hasMany(Affiliate::class);
    }
}
