<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMerchan extends Model
{
    protected $fillable = [
        'product_id','quantity',
    ];
}
