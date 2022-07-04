<?php

namespace App\Http\Livewire\Admin\Brands;

use Livewire\Component;

class Edit extends Component{
    public $brand;
    
    public function mount($brand){
        $this->brand = $brand;
    }
    
    protected $rules = [
        'brand.name' => 'required|unique:brands,name',
    ];
    
    public function update(){
        $this->validate();
        $this->brand->save();
        redirect()->route('admin.brands.index')->with('success', $this->brand->name . ' actualizado correctamente');
    }

    public function render(){

        return view('livewire.admin.brands.edit');
    }
}
