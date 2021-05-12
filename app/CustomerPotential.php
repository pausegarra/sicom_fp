<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPotential extends Model
{
    protected $fillable = ['name','surname','phone','email','status','company','job','address','city','county','country','postcode'];
}
