<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller{

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('can:admin.permissions.index')->only('index');
        $this->middleware('can:admin.permissions.create')->only('create');
        $this->middleware('can:admin.permissions.show')->only('show');
        $this->middleware('can:admin.permissions.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');

    }
    
    public function index(){
        return view('admin.permissions.index');
    }
    
    public function create(){
        return view('admin.permissions.create');
    }
    
    public function show(Permission $permission){
        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission){
        return view('admin.permissions.edit',compact('permission'));
    }
}
