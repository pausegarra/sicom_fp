<?php

namespace App\Http\Livewire;

use App\Order;
use Livewire\Component;

class OrdersList extends Component
{
    public $orders = [],$idOrder,$status;

    public function render()
    {
        $this->getOrders();
        return view('livewire.orders-list');
    }

    private function getOrders() {
        $query = Order::query();
        $query->where('user_id',auth()->user()->id);
        $query->when($this->idOrder,function($q) {
            return $q->where('id','like',"%$this->idOrder%");
        });
        $query->when($this->status,function($q) {
            if ($this->status == 1)
                return $q->where('erp_id','!=',null);
            else
                return $q->where('erp_id','==',null);
        });
        $this->orders = $query->with('user')
            ->get();
    }

    public function resetFilters() {
        $this->id = null;
        $this->status = null;
    }
}
