<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller{

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('can:admin.products.index')->only('index');
        $this->middleware('can:admin.products.create')->only('create');
        $this->middleware('can:admin.products.show')->only('show');
        $this->middleware('can:admin.products.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');

    }

    public function details(){  
        return view('admin.products.details');
        
    }
    public function movements(){  
        return view('admin.products.movements');
        
    }

    public function index(){
       return view('admin.products.index');
    }

    public function create(){
        return view('admin.products.create');
    }

    

    public function show(Product $product){
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product){
        return view('admin.products.edit', compact('product'));
    }

 
}
