<?php

namespace App\Http\Livewire\Admin\Brands;

use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component{

    public $name;
    public $redirect;

    public function mount($redirect = true){
        $this->redirect = $redirect;
    }
    
    public function save(){
        $this->validate([
            'name' => 'required|unique:brands,name',
            
        ]);
    
        $brand = Brand::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        if($this->redirect){
            redirect()->route('admin.brands.index')->with('success',  $brand->name . ' creado correctamente');        
            
        }else {
           $this->emit('closeBrandModal', $brand->id);
           $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $brand->name . ' ha sido creado correctamente',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
            ]);
        }
    
    
    
    }


    public function render(){

        return view('livewire.admin.brands.create');
    }
}
