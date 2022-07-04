<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller{

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('can:admin.brands.index')->only('index');
        $this->middleware('can:admin.brands.create')->only('create');
        $this->middleware('can:admin.brands.show')->only('show');
        $this->middleware('can:admin.brands.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');

    }
    
    public function index(){
        return view('admin.brands.index');
    }
    
    public function create(){
        return view('admin.brands.create');
    }

    public function show(Brand $brand){
        return view('admin.brands.show', compact('brand'));
    }
    
    public function edit(Brand $brand){
        return view('admin.brands.edit', compact('brand'));
    }
    
}
