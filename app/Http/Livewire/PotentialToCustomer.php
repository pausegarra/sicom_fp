<?php

namespace App\Http\Livewire;

use App\Customer;
use Livewire\Component;
use App\CustomerPotential;
use App\PaymentMethod;
use App\Sector;

class PotentialToCustomer extends Component
{
    public $customer,$customer_id,$paymentMethods,$paymentTerms = [],$sectors;
    public $paymentMethod,$cif,$paymentTerm,$sector;
    protected $rules = [
        'cif'           => 'required',
        'paymentMethod' => 'required',
        'paymentTerm'   => 'required',
        'sector'        => 'required',
    ];

    public function mount() {
        $this->customer = CustomerPotential::findOrFail($this->customer_id);
        $this->paymentMethods = PaymentMethod::with('payment_terms')
            ->get();
        $this->sectors = Sector::all();
    }

    public function updated($field) {
        $this->validateOnly($field);
    }

    public function render()
    {
        return view('livewire.potential-to-customer');
    }

    public function handlePaymentMethodSelect() {
        if ($this->paymentMethod) {
            $pm = $this->paymentMethods
                ->find($this->paymentMethod);
            $this->paymentTerms = $pm->payment_terms;
        }
    }

    public function handleSave() {
        $validatedData = $this->validate();
        $this->customer->cif = $this->cif;
        $this->customer->payment_term_id = $this->paymentTerm;
        $this->customer->payment_method_id = $this->paymentMethod;
        $this->customer->sector_id = $this->sector;
        unset($this->customer->county);
        $custData = $this->customer->toArray();
        $newCustomer = auth()->user()->customers()->create($custData);
        $this->customer->delete();
        return redirect(route('customer.show',$newCustomer->id));
    }
}
