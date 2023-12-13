<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Client\Product\Cart;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Client\Checkout\Checkout;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

     public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    // Define the relationship between User and Checkout
    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }


    /**
     * The attributes that are mass assignable.
     * @var array
     */
     protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

  
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($password)
    {
        // $this->attributes['password'] = bcrypt($value);
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }
}
