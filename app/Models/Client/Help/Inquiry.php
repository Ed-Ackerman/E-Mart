<?php

namespace App\Models\Client\Help;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'tel', 'inquiry' /* other fillable attributes */];
}
