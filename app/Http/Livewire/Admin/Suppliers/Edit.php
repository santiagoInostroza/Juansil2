<?php

namespace App\Http\Livewire\Admin\Suppliers;

use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component{

    public $supplier;
    
    public function mount($supplier){
        $this->supplier = $supplier;
    }
    
    protected $rules = [
        'supplier.name' => 'required|unique:suppliers,name',
    ];
    
    public function update(){
        $this->validate();
        $this->supplier->slug = Str::slug($this->supplier->name);
        $this->supplier->save();
        redirect()->route('admin.suppliers.index')->with('success', $this->supplier->name . ' actualizado correctamente');
    }

    public function render(){

        return view('livewire.admin.suppliers.edit');
    }
}
