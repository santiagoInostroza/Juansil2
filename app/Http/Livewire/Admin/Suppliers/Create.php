<?php

namespace App\Http\Livewire\Admin\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Support\Str;

class Create extends Component{

    public $name;
    public $redirect;
    
    public function mount($redirect = true){
        $this->redirect = $redirect;
    }
    
    public function save(){
        $this->validate([
            'name' => 'required|unique:suppliers,name',
        ]);
    
        $supplier = Supplier::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);
    
        if($this->redirect){
            redirect()->route('admin.suppliers.index')->with('success',  $supplier->name . ' creado correctamente');        
        }else {
           $this->emit('closeSupplierModal', $supplier->id);
        }
    }

    public function render(){

        return view('livewire.admin.suppliers.create');
    }
}
