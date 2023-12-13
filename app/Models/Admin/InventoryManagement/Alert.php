<?php

namespace App\Models\Admin\InventoryManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['product_id', 'message'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
