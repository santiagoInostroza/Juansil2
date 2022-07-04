<?php

namespace App\Http\Livewire\Admin\Customers;

use App\Models\Address;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Str;

class Create extends Component{

    public $name;
    public $email;
    public $celphone;


    public $redirect;



    protected $listeners = [
        'closeAddressModal',
    ];

    public function rules(){
        $rules =[
            'name' => 'required|unique:customers',
            'email' => 'nullable|email|unique:customers',
            'celphone' => 'nullable|string|max:255',
        ];
        
        return $rules;
    }

  


    public function closeAddressModal(Address $address){
     
        
    }  

    public function mount($redirect = true){
        $this->redirect = $redirect;
        $this->addressModal = false;
    }
    
    public function save(){
        $this->validate();

        $customer = Customer::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'email' => $this->email,
            'celphone' => $this->celphone,
        ]);

       
    
        if($this->redirect){
            redirect()->route('admin.customers.edit',$customer)->with('success', 'El cliente '. $customer->name . ' ha sido creado correctamente!!');        
        }else {
            $this->emit('closeCustomerModal', $customer->id);
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'El cliente '. $customer->name . ' ha sido creado correctamente',
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
                ]);
        }
    }


    public function render(){

        // $this->addresses = Address::all()->map(function($address){
        //     return [
        //         'id' => $address->id,
        //         'name' => $address->name,
        //     ];
        // });
        

        return view('livewire.admin.customers.create');
    }
}
