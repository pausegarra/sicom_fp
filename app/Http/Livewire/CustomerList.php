<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;

class CustomerList extends Component
{
    public $customers;
    public $name,$code,$nif;

    protected $listeners = [
        'updateClients' => 'render',
    ];

    public function resetFilters() {
        $this->name = "";
        $this->code = "";
        $this->nif  = "";
    }

    private function getCustomers() {
        $query = Customer::query();
        $query->where('user_id',auth()->user()->id);
        $query->when($this->name,function($q) {
            return $q->where('name','like',"%$this->name%");
        });
        $query->when($this->code,function ($q) {
            return $q->where('id','like',"%$this->code%");
        });
        $query->when($this->nif,function ($q) {
            return $q->where('cif','like',"%$this->nif%");
        });
        $this->customers = $query->get();
    }

    public function render()
    {
        $this->getCustomers();
        return view('livewire.customer.customer-list');
    }
}
