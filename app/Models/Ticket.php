<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'name',
        'price',
        'sku',
        'categories',
        'quantity_discounts',
        'can_select_quantity',
        'image',
        'description',
        'additional_info',
        'image',
        'stock'
    ];

    protected $casts = [
        'categories' => 'array',
        'quantity_discounts' => 'array',
        'can_select_quantity' => 'boolean',
    ];

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function hasEnoughStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    public function reduceStock($quantity)
    {
        if ($this->hasEnoughStock($quantity)) {
            $this->stock -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    public function getDiscountedPrice($quantity)
    {
        if (empty($this->quantity_discounts)) {
            return $this->price;
        }

        $discounts = is_string($this->quantity_discounts) ? json_decode($this->quantity_discounts, true) : $this->quantity_discounts;
        
        foreach ($discounts as $discount) {
            if ($quantity >= $discount['min'] && 
                ($discount['max'] === null || $quantity <= $discount['max'])) {
                return $discount['price'];
            }
        }

        return $this->price;
    }
} 