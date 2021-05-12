<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use App\Mail\CustomerCreated;
use Illuminate\Support\Facades\Mail;

class CustomerForm extends Component
{
    public $name,
           $country,
           $cif,
           $email,
           $phone,
           $address,
           $city,
           $postCode,
           $payment_method_id,
           $payment_term_id,
           $sector_id;
    public $paymentTermsToSelect = [],
           $paymentMethodsToSelect = [],
           $sectorsToSelect = [];

    protected $rules = [
        'name'              => 'required|max:50',
        'country'           => 'required',
        'email'             => 'required|email|max:80',
        'city'              => 'required|max:30',
        'postCode'          => 'required|max:5|min:5',
        'payment_method_id' => 'required',
        'payment_term_id'   => 'required',
        'sector_id'         => 'required',
        'phone'             => 'required|max:9',
        'address'           => 'required|max:50',
        'cif'               => 'required|max:9'
    ];

    public function updated($prop) {
        $this->validateOnly($prop);
    }
    
    public function handleFormSubmit() {
        $validatedData = $this->validate();
        $customerData = auth()->user()->customers()->create($validatedData);
        $this->reset();
        $this->emit('updateClients');
        Mail::to("p.segarra@tecnol.es")
            ->send(new CustomerCreated($customerData));
    }

    public function handlePaymentMethodChange() {
        $pm = $this->paymentMethodsToSelect
            ->find($this->payment_method_id);
        $this->paymentTermsToSelect = $pm->payment_terms;
    }

    public function mount() {
        $this->paymentMethodsToSelect = \App\PaymentMethod::with('payment_terms')
            ->get();
        $this->sectorsToSelect = \App\Sector::all();
    }

    public function render()
    {
        $this->emit('updateFields');
        return view('livewire.customer.customer-form');
    }
}
