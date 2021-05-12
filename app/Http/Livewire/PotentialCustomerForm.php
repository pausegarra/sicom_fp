<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\CustomerPotential;

class PotentialCustomerForm extends Component
{
    public $name,$surname,$company,$job,$email,$phone,$country,$county,$city,$postcode,$address,$status;

    protected $rules = [
        'name'     => 'required',
        'surname'  => 'required|max:50',
        'job'      => 'required|max:50',
        'company'  => 'required',
        'phone'    => 'required|max:9',
        'email'    => 'email|required',
        'country'  => 'required',
        'county'   => 'required',
        'city'     => 'required',
        'postcode' => 'required',
        'address'  => 'required',
        'status'   => 'required',
    ];

    public function mount(){
        $this->status = 0;
    }

    public function updated($prop) {
        $this->validateOnly($prop);
    }

    public function handleSubmitForm() {
        $validatedData = $this->validate();
        auth()->user()->potentialCustomers()->create($validatedData);
        $this->reset();
        $this->emit('updatePotentialCustomers');
    }

    public function render()
    {
        return view('livewire.potential-customer.potential-customer-form');
    }
}
