<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Index extends Component{

    use WithPagination;
    
    public $search;
    public $numRows;
    public $columns;

    public $sortField;
    public $sortOrder;
    
    public function mount(){
        $this->search = '';
        $this->numRows = (session()->has('permission.numRows') ) ? session('permission.numRows') : 10;
        $this->columns = (session()->has('permission.columns') ) ? session('permission.columns') : [
            'id' => ['value' =>true, 'name' =>'Id'], 
            'name' => ['value' =>true, 'name' =>'Nombre'],
            'description' => ['value' =>true, 'name' =>'Descripción'],
            'guard_name' => ['value' =>true, 'name' =>'Guard'],
            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('permission.sortField') ) ? session('permission.sortField') : 'id';
        $this->sortOrder = (session()->has('permission.sortOrder') ) ? session('permission.sortOrder') : 'asc';
    }
    
    public function selectColumns($value){
        switch ($value) {
            case 'all':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = true;
                }
                break;
            case 'none':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = false;
                }
                break;
            case 'switch':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = !$this->columns[$name_column]['value'];
                }
                break;
            
            default:
                
                break;
        }
        session(['permission.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'permission.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'permission.columns' => $this->columns
        ]);
    }

   

    
    
    
    
    public function render(){
        $permissions = Permission::
        where('name', 'like', "%{$this->search}%")
        ->orWhere('description', 'like', "%{$this->search}%")
        ->orderBy($this->sortField, $this->sortOrder)
        ->paginate($this->numRows);

        return view('livewire.admin.permissions.index', compact('permissions'));
    }


    public function delete($id){
        $permission = Permission::find($id);
        $permission->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $permission->name . ' ha sido eliminado correctamente',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);
    }

    public function sortBy($column){
        $this->sortField = $column;
        $this->sortOrder = $this->sortOrder == 'asc' ? 'desc' : 'asc';
        session([
            'permission.sortOrder' => $this->sortOrder
        ]);
        session([
            'permission.sortField' => $this->sortField
        ]);
    }

    
  

}
