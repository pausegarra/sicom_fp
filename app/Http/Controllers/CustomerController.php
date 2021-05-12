<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\CustomerPotential;
use App\Order;

class CustomerController extends Controller
{
    public function storeCustomer(Request $req) {
        Customer::validateCustomer($req);
        return Customer::create($req->all());
    }

    public function show($id) {
        $customer = Customer::with('sector')
            ->findOrfail($id);
        return view('livewire.customer.show',compact('customer'));
    }

    public function showOrder(Order $order) {
        return view('order',compact('order'));
    }

    public function showPotential($id) {
        $customer = CustomerPotential::findOrFail($id);
        return view('potential-customer-show',compact('customer'));
    }

    public function convertToCustomer(Request $req) {
        return $req;
    }
}
