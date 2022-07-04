<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public function render(){

        $roles = Role::all();
        $permissions = Permission::all();
        return view('livewire.admin.roles.index',compact('roles','permissions'));
    }

    public function changeRole($role,$permission_id){
       $role = Role::find($role);
       $permission = Permission::find($permission_id);
       if ($role->hasPermissionTo($permission_id)) {
              $role->revokePermissionTo($permission_id);
              $this->dispatchBrowserEvent('salert',[
                'title' => "Permiso '$permission->description' eliminado de '$role->name' ",
                'toast' => true,
                'position' => 'top',
                'timer' => 2400,
           ]);
       }else{
              $role->givePermissionTo($permission_id);
              $this->dispatchBrowserEvent('salert',[
                'title' => "Permiso '$permission->description' agregado a '$role->name' ",
                'toast' => true,
                'position' => 'top',
                'timer' => 2400,
           ]);
       }

       
       
    }

    public function delete(Role $role){
        $role->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' => "Rol '$role->name' eliminado",
            'toast' => true,
            'position' => 'top',
            'timer' => 2400,
       ]);
    }
}
