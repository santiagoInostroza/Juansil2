<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller{

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('can:admin.roles.index')->only('index');
        $this->middleware('can:admin.roles.create')->only('create');
        $this->middleware('can:admin.roles.show')->only('show');
        $this->middleware('can:admin.roles.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');

    }

    public function index(){
       return view('admin.roles.index');
    }

    public function create(){
        return view('admin.roles.create');
    }

    public function show($id){
        //
    }

    public function edit($id){
        //
    }

    
}
