<?php

namespace App\Http\Livewire\Admin\Customers;

use App\Models\Address;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Edit extends Component{

    public $customer;
    
    public $name;
    public $email;
    public $celphone;
    
    public $address_id;
    public $address_name;

    
    public $redirect;
    public $addressModal;

    public $addresses;

    protected $listeners = [
       
    ];

 
    public function rules(){
       return  [
            'name' => ['required', Rule::unique('customers')->ignore($this->customer)],
            'email' => ['nullable', Rule::unique('customers')->ignore($this->customer)],
            'celphone' => 'nullable|string|max:255',
        ];
    }


    public function mount($redirect = true){
        $this->redirect = $redirect;
        $this->name = $this->customer->name;
        $this->email = $this->customer->email;
        $this->celphone = $this->customer->celphone;
       
    }
    
    public function update(){
        $this->validate();
        $slug = $this->customer->slug;  

        $this->customer->name = $this->name;
        $this->customer->email = $this->email;
        $this->customer->celphone = $this->celphone;
        $this->customer->slug = Str::slug($this->customer->name);   
        $this->customer->save();  
        
        if($slug != $this->customer->slug){
            redirect()->route('admin.customers.edit', $this->customer);
        }

      
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'Se ha actualizado los datos',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);
    }


    public function render(){

        $this->addresses = Address::all()->map(function($address){
            return [
                'id' => $address->id,
                'name' => $address->address,
            ];
        });

        return view('livewire.admin.customers.edit');
    }
}
