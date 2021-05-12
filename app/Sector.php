<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function clients(){
        return $this->hasMany(\App\Customer::class);
    }
}
