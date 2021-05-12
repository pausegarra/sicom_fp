<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','logout','sso_user_id', 'email', 'password', 'api_token'
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

    public function salespersonCode() {
        return $this->hasOne(\App\SalesPersonCode::class);
    }

    public function orders() {
        return $this->hasMany(\App\Order::class);
    }

    public function customers() {
        return $this->hasMany(\App\Customer::class);
    }

    public function potentialCustomers() {
        return $this->hasMany(\App\CustomerPotential::class);
    }
}
