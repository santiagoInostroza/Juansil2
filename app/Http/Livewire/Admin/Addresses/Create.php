<?php

namespace App\Http\Livewire\Admin\Addresses;

use App\Models\Address;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component{

    public $customer;

 
    public $redirect;
    
    public $name;
    public $alias;
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
        'setAddress'
    ];

    // protected $rules = [
    //     'name' => 'required',
    //     'alias' => 'nullable',
    //     'street' => 'nullable|string|max:255',
    //     'number' => 'required|string|max:255',
    //     'commune' => 'required|string|max:255',
       
    //     'tower' => 'nullable|string|max:255',
    //     'department' => 'nullable|string|max:255',
    //     'place_id' => 'required|string|max:255',
    //     'longitude' => 'required',
    //     'latitude' => 'required',
    //     'comment' => 'nullable|string|max:255',
    
    // ];

    public function rules(){
       

        return [
            'name' => 'required|unique:addresses',
            'alias' => 'nullable',
            'street' => 'nullable|string|max:255',
            'number' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
           
            'tower' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'place_id' => 'required|string|max:255',
            'longitude' => 'required',
            'latitude' => 'required',
            'comment' => 'nullable|string|max:255',
        
        
        ];
    }

    public function mount($redirect = true, $customer = null){
        $this->redirect = $redirect;
        $this->customer = $customer;
        $this->alias = null;
    }

    public function setAddress($address){
        $address = json_decode(json_encode($address));
        $this->name = $address->street . ' ' . $address->number . ' ' . $address->commune;
        //  $this->address .= ($this->tower) ?  ', Torre ' . $this->tower : ''; 
        //  $this->address .= ($this->department) ?  ', Departamento ' . $this->department : ''; 

        $this->street = $address->street;
        $this->number = $address->number;
        $this->commune = $address->commune;
        $this->place_id = $address->place_id;
        $this->longitude = $address->longitude;
        $this->latitude = $address->latitude;
    }



    public function closeModal(Address $address){
        $this->addressModal = false;
        $this->category_id = $address->id;
    }  
   
    
    public function save(){

        $this->name = $this->street . ' ' . $this->number . ' ' . $this->commune ;
        $this->name .= ($this->tower) ? ' T.' . $this->tower : '' ;
        $this->name .= ($this->department) ?  ' D.' . $this->department : '' ;


        $this->validate();

        // $address = Address::where('name', $this->address)->first();

        $address = $this->customer->addresses()->where('name', $this->name)->first();
       


        if(!$address){
            $address = Address::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'alias' => ($this->alias) ? $this->alias : $this->name,
                'street' => $this->street,
                'number' => $this->number,
                'commune' => $this->commune,
               
                'tower' => $this->tower,
                'department' => $this->department,
                'place_id' => $this->place_id,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'comment' => $this->comment,
                'customer_id' => $this->customer->id,
                'default' => ( $this->customer->addresses->count() ) ? false : true,
            
            ]);

           

            if($this->redirect){
                redirect()->route('admin.addresses.index')->with('success',  $address->name . ' creado correctamente');        
            }else {
                $this->emit('closeAddressModal', $address->id);
              

                $this->dispatchBrowserEvent('salert',[
                    'title' =>  'Se ha agregado la dirección '. $address->name . ' correctamente',
                    'type' => 'success',
                    'position' => 'top',
                    'toast' => true,
                    'timer' => 2400,
                    ]);
            }

            return;
        }

        if($this->redirect){
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'Ya existe '. $address->name,
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
                ]);    
        }else {
            $this->emit('closeAddressModal', $address->id);
            $this->dispatchBrowserEvent('salert',[
                'title' =>  $address->name . ' seleccionado',
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
                ]);
        }

    
        
    
        
    }

    public function render(){
        return view('livewire.admin.addresses.create');
    }
}
