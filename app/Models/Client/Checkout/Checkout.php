<?php

namespace App\Models\Client\Checkout;

use App\Models\User;
use App\Models\Client\Product\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'tel_1',
        'tel_2',
        'city',
        'shipping_fee',
        'address',
        'payment_method',
        'order_status',
        'cart_items',
        // Add other fields as needed
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
