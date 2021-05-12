<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public function payment_terms(){
        return $this->belongsToMany(\App\PaymentTerm::class);
    }
}
