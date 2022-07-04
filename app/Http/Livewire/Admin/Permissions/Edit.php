<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;

class Edit extends Component{
    public $permission;

    public function mount($permission){
        $this->permission = $permission;
    }

    protected $rules = [
        'permission.name' => 'required|string|max:255',
        'permission.description' => 'required',
    ];
    
    public function update(){
        $this->validate();
        $this->permission->save();
        redirect()->route('admin.permissions.index')->with('success', 'Permiso actualizado correctamente');
    }

    public function render(){
        return view('livewire.admin.permissions.edit');
    }

    
}
