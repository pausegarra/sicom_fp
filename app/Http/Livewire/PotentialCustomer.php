<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\CustomerPotential;

class PotentialCustomer extends Component
{
    public $customers;
    public $name,$company,$state;

    public function mount() {
        $this->state = 2;
    }

    public function resetFilters() {
        $this->name    = "";
        $this->company = "";
        $this->state   = 2;
    }

    private function getCustomers() {
        $query = CustomerPotential::query();
        $query->where('user_id',auth()->user()->id);
        $query->when($this->name,function ($q) {
            return $q->where('name','like',"%$this->name%");
        });
        $query->when($this->company,function ($q) {
            return $q->where('company','like',"%$this->company%");
        });
        $query->when($this->state == 1 || $this->state == 0,function ($q) {
            return $q->where('status',$this->state);
        });
        $this->customers = $query->get();
    }

    public function render()
    {
        $this->getCustomers();
        return view('livewire.potential-customer.potential-customer');
    }
}
