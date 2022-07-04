<?php

namespace App\Http\Livewire\Admin\Customers\Addresses;

use App\Models\Address;
use Livewire\Component;

class Edit extends Component{
    public $addresses;
    public $customer;

    public $addressModal;
    public $editAddressModal;
    

    protected $listeners = [
        'closeAddressModal',
        'closeEditAddressModal',
    ];

    public function mount(){
        $this->addressModal = false;  
        if ($this->customer) {
            foreach($this->customer->addresses as $address){
                $this->editAddressModal[$address->id] = false;
            }   
        } 
    }

    public function closeAddressModal(){
        $this->addressModal = false;
        foreach($this->customer->addresses as $address){
            $this->editAddressModal[$address->id] = false;
        }   
    }  

    public function closeEditAddressModal(){
        foreach($this->customer->addresses as $address){
            $this->editAddressModal[$address->id] = false;
        } 
    }


    public function render(){
        if ($this->customer) {
            $this->addresses = Address::where('customer_id', $this->customer->id)->get();
        }

        return view('livewire.admin.customers.addresses.edit');
    }

    public function makeDefault(Address $address){
        foreach ($this->customer->addresses as $value) {
            $value->default = false;
            $value->save();
        }
        $address->default = true;
        $address->save();

    }

    public function delete(Address $address){
        $address->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'Dirección '. $address->alias . ' eliminado!!',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);

    }
}
