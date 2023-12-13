<?php

namespace App\Models\Client\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    use HasFactory;
    protected $fillable = [
       'name',
       'city',
       'address',
       'tel_1',
       'tel_2',
       'shipping_fee',
       'payment_method',
       'order_status',
       'custom_order',
    ];
}
