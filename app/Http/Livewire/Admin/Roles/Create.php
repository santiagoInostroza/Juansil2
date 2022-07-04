<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component{
    public $name;

    public function render(){
        return view('livewire.admin.roles.create');
    }

    public function saveRol(){
        $this->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $role = Role::create([
            'name' =>  $this->name,
            'guard_name' => 'web',
        ]);

        redirect()->route('admin.roles.index')->with('success','Rol creado correctamente');
      
    }
}
