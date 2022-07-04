<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;

class Show extends Component{
    public $permission;

    public function mount($permission){
        $this->permission = $permission;
    }


    public function render(){
        
        return view('livewire.admin.permissions.show');
    }
}
