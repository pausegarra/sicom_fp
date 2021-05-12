<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{
    public function payment_methods(){
        return $this->belongsToMany(\App\PaymentMethod::class);
    }
}
