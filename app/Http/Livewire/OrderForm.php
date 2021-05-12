<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Customer;
use App\Product;

class OrderForm extends Component
{
    use WithFileUploads;

    public $hour,$time,$work_reference,$payment_method_id,$payment_term_id,$carrier = 'standard',$contact_id,$cif,$phone,$email,$vat,$howRecieveInvoice = 'mail',$rows,$merchanRows,$orderNotes,$priceNotes,$files=null;
    public $customer,$customers,$customerId,$paymentMethods,$paymentTerms,$products,$merchan,$total=0,$totalPrice=0;
    private $rowArr = [
        'product'  => null,
        'units'    => null,
        'discount' => 0,
        'price'    => 0.00,
    ],$merchanRow = [
        'product' => null,
        'units'   => null,
    ];

    protected $queryString = [
        'customerId' => ['except' => ''],
    ];

    protected $listeners = [
        'updateClients' => '$refresh',
        'updateCustomer' => 'setCustomer',
    ];

    protected $rules = [
        'customerId'        => 'required',
        'payment_method_id' => 'required',
        'payment_term_id'   => 'required',
    ];

    public function handleCustomerSelect() {
        $this->customer = $this->customers
            ->find($this->customerId);
        $this->payment_method_id = $this->customer->paymentMethod->id;
        $this->handlePaymentMethodChange();
        $this->cif = $this->customer->cif;
        $this->phone = $this->customer->phone;
        $this->email = $this->customer->email;
    }

    public function setCustomer($customerId) {
        $this->customerId = $customerId;
        $this->handleCustomerSelect();
    }

    public function handlePaymentMethodChange() {
        $this->paymentTerms = $this->paymentMethods
            ->find($this->payment_method_id)
            ->payment_terms;
        $this->payment_term_id = $this->customer->paymentTerm->id;
    }

    public function setDiscount($discountType,$key) {
        $this->rows[$key]['discountType'] = $discountType;
        $this->rows[$key]['discountLabel'] = ($discountType == 'percent') ? '%' : 'Sin cargo';
        $this->emit('rowAdded');
    }

    public function mount() {
        $this->vat = 21;
        $this->rows = [];
        array_push($this->rows,$this->rowArr);
        $this->merchanRows = [];
        array_push($this->merchanRows,$this->merchanRow);
        $this->customers = Customer::with('paymentTerm','paymentMethod')
            ->get();
        $this->paymentMethods = \App\PaymentMethod::with('payment_terms')
            ->get();
        $this->products = Product::where('active',1)
            ->where('type','product')
            ->get();
        $this->merchan = Product::where('active',1)
            ->where('type','merchan')
            ->get();
        if($this->customerId != null)
            $this->handleCustomerSelect();
    }

    public function add($row) {
        $rowArr = ($row == 'rows') ? 'rowArr' : 'merchanRow';
        array_push($this->$row,$this->$rowArr);
    }

    public function remove($key,$row) {
        unset($this->$row[$key]);
    }

    public function saveOrder(){
        $validatedFields = $this->validate();

        $order = $this->customer->orders()->create([
            'user_id'           => auth()->user()->id,
            'work_reference'    => $this->work_reference,
            'payment_method_id' => $this->payment_method_id,
            'payment_term_id'   => $this->payment_term_id,
            'carrier'           => $this->carrier,
            'vat'               => $this->vat,
            'howRecieveInvoice' => $this->howRecieveInvoice,
            'notes'             => $this->orderNotes,
            'price_notes'       => $this->priceNotes,
        ]);

        foreach ($this->rows as $row) {
            $order->rows()->create([
                'product_id' => $row['product'],
                'price'      => $row['price'],
                'discount'   => $row['discount'],
                'units'      => $row['units']
            ]);
        }

        foreach ($this->merchanRows as $merchan) {
            if ($merchan['product'] == null || $merchan['units'] == null)
                break;
            $order->merchan()->create([
                'product_id' => $merchan['product'],
                'quantity'   => $merchan['units'],
            ]);
        }

        if ($this->files) {
            foreach($this->files as $file) {
                $order->files()->create([
                    'filename' => $file->getClientOriginalName(),
                ]);
                $file->storeAs('orderFiles',$file->getClientOriginalName());
            }
        }

        $this->emit('orderSaved');
    }

    public function update($field) {
        $this->validateOnly($field);
    }

    public function render()
    {
        return view('livewire.order.order-form');
    }
}