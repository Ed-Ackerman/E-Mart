<?php

namespace App\Models\Admin\CustomerSupportManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'question', 'answer' /* other fillable attributes */];
}
