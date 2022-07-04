<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller{
    public function __construct(){
    
        $this->middleware('auth');
        $this->middleware('can:admin.addresses.index')->only('index');
        $this->middleware('can:admin.addresses.create')->only('create');
        $this->middleware('can:admin.addresses.show')->only('show');
        $this->middleware('can:admin.addresses.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');
    
    }
    public function index(){
    return view('admin.addresses.index');
     }
    
     public function create(){
         return view('admin.addresses.create');
     }
    
     public function show(Address $address){
        
         return view('admin.addresses.show', compact('address'));
     }
    
     public function edit(Address $address){
        
         return view('admin.addresses.edit', compact('address'));
     }
    
}
