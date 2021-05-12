<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderRow extends Model
{
    protected $fillable = [
        'product_id','price','discount','units',
    ];

    public function product() {
        return $this->belongsTo(\App\Product::class);
    }
}
