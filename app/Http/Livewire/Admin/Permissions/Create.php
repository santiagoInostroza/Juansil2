<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Create extends Component{
    public $name;
    public $description;

    public function save(){
        $this->validate([
            'name' => 'required|unique:permissions,name',
            'description' => 'required',
        ]);

        $permission = Permission::create([
            'name' => $this->name,
            'description' => $this->description,
            'guard_name' => 'web',
        ]);

        // Add to role superAdmin
        $role = Role::where('name', 'SuperAdmin')->first();
        $role->givePermissionTo($permission);


        redirect()->route('admin.permissions.index')->with('success', 'Permiso '. $permission->name . ' creado correctamente');        

       
    }

    public function render(){
        return view('livewire.admin.permissions.create');
    }
}
