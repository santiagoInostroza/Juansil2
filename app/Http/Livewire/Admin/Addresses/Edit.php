<?php

namespace App\Http\Livewire\Admin\Addresses;

use App\Models\Address;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Str;

class Edit extends Component{


    public $customer;

    public $redirect;
    public $addressObject;
    
    public $address;
    public $street;
    public $number;
    public $commune;
    public $tower;
    public $department;
    public $place_id;
    public $longitude;
    public $latitude;
    public $comment;
    
    public $addressModal;
    
    protected $listeners = [
        'closeAddressModal',
        'setAddress'
    ];

    protected $rules = [
        'addressObject.name' => 'required',
        'addressObject.alias' => 'nullable',
        'addressObject.street' => 'nullable|string|max:255',
        'addressObject.number' => 'required|string|max:255',
        'addressObject.commune' => 'required|string|max:255',
       
        'addressObject.tower' => 'nullable|string|max:255',
        'addressObject.department' => 'nullable|string|max:255',
        'addressObject.place_id' => 'required|string|max:255',
        'addressObject.longitude' => 'required',
        'addressObject.latitude' => 'required',
        'addressObject.comment' => 'nullable|string|max:255',
    
    ];

    public function setAddress($address){
        $address = json_decode(json_encode($address));
        $this->addressObject->name = $address->address;
        $this->addressObject->street = $address->street;
        $this->addressObject->number = $address->number;
        $this->addressObject->commune = $address->commune;
        $this->addressObject->place_id = $address->place_id;
        $this->addressObject->longitude = $address->longitude;
        $this->addressObject->latitude = $address->latitude;
    }

    public function closeAddressModal(Address $address){
        $this->addressModal = false;
      
    }  
    public function mount($redirect = true){
        $this->redirect = $redirect;     
        $this->customer = Customer::find($this->addressObject->customer_id); 
         
    }
    
    public function save(){
        $this->validate();

        $this->addressObject->slug = Str::slug($this->addressObject->name);
        $this->addressObject->save();

        if($this->customer){
            redirect()->route('admin.customers.edit', $this->customer)->with('success',  'Dirección ' . $this->addressObject->address . ' actualizada correctamente!');   
        }else if($this->redirect){
            redirect()->route('admin.addresses.index')->with('success',  'Dirección ' . $this->addressObject->address . ' actualizada correctamente!');        
        }else {
           $this->emit('closeEditAddressModal',  $this->addressObject->id);
            $this->dispatchBrowserEvent('salert',[
                'title' => 'Dirección ' . $this->addressObject->address . ' actualizada correctamente!',
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
                ]);
        }
    }

    public function render(){
        return view('livewire.admin.addresses.edit');
    }
}
