<?php

namespace App;

use App\Services\NavisionService;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','work_reference','payment_method_id','payment_term_id','carrier','vat','howRecieveInvoice','notes','price_notes',
    ];

    public function paymentMethod() {
        return $this->belongsTo(\App\PaymentMethod::class);
    }

    public function paymentTerm(){
        return $this->belongsTo(\App\PaymentTerm::class);
    }

    public function rows() {
        return $this->hasMany(\App\OrderRow::class);
    }

    public function merchan() {
        return $this->hasMany(\App\OrderMerchan::class);
    }

    public function files() {
        return $this->hasMany(\App\OrderFile::class);
    }

    public function customer(){
        return $this->belongsTo(\App\Customer::class);
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function getOrderTotal() {
        $total = 0;
        foreach ($this->rows as $row) {
            $total = $row->price * $row->units;
        }
        return number_format($total, 2, ',', ' ');
    }
}
