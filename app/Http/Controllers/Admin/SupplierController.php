<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller{

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('can:admin.suppliers.index')->only('index');
        $this->middleware('can:admin.suppliers.create')->only('create');
        $this->middleware('can:admin.suppliers.show')->only('show');
        $this->middleware('can:admin.suppliers.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');

    }

    public function index(){
        return view('admin.suppliers.index');
    }
    
     public function create(){
         return view('admin.suppliers.create');
     }
    
     public function show(Supplier $supplier){
         return view('admin.suppliers.show', compact('supplier'));
     }
    
     public function edit(Supplier $supplier){
         return view('admin.suppliers.edit', compact('supplier'));
     }
   
}
