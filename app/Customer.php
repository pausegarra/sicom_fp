<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name','email','cif','address','postCode','county','city','phone','sector_id','payment_term_id','payment_method_id','type'
    ];

    public static function createNav($data) {
        return $data;
    }

    public function sector() {
        return $this->belongsTo(\App\Sector::class);
    }

    public function orders(){
        return $this->hasMany(\App\Order::class);
    }

    public function paymentMethod() {
        return $this->belongsTo(\App\PaymentMethod::class);
    }

    public function paymentTerm(){
        return $this->belongsTo(\App\PaymentTerm::class);
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }
}
