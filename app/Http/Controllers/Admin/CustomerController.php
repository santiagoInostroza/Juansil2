<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller{

    public function __construct(){
    
        $this->middleware('auth');
        $this->middleware('can:admin.customers.index')->only('index');
        $this->middleware('can:admin.customers.create')->only('create');
        $this->middleware('can:admin.customers.show')->only('show');
        $this->middleware('can:admin.customers.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');
    
    }
    public function index(){
    return view('admin.customers.index');
     }
    
     public function create(){
         return view('admin.customers.create');
     }
    
     public function show(Customer $customer){
         return view('admin.customers.show', compact('customer'));
     }
    
     public function edit(Customer $customer){
         return view('admin.customers.edit', compact('customer'));
     }
    
}
