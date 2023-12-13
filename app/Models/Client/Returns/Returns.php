<?php

namespace App\Models\Client\Returns;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;
    protected $table = 'returns';

    protected $fillable = [
        'product_name',
        'product_code',
        'return_reason',
        'name',
        'tel_1',
        'tel_2',
        'city',
        'address',
        'return_status',
        'payment_method',
        'shipping_fee',
    ];
}
