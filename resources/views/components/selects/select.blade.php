<div id="select_{{rand()}}"  class="sm:rounded-lg"
    x-on:click.away="isOpen=false"
    x-on:keydown.escape="isOpen=false"
    x-on:keydown.tab="isOpen=false"
    x-on:keydown.shift.tab="isOpen=false"
    x-data="{
        isOpen:'{{$isOpen}}',
        search:'{{$search}}',
        value:'',
        noClose:'{{$noClose}}',
       
        collection:{{$collection}},
        getCollection:function(){
            return this.collection.filter(function(item){
                return item.name.toLowerCase().includes(this.search.toLowerCase());
            }.bind(this));
        },
        selectItem:function(item){

            if(item == null){
                this.value = '';
                this.search = '';
                element = $refs.ref_value;
                element.value='';
                nameWire =element.getAttribute('wire:model') ;
                nameWire2 =element.getAttribute('wire:model.defer') ;
                nameWire3 =element.getAttribute('wire:model.lazy') ;
                if(nameWire != null){
                    this.$wire.set(nameWire, this.value)
                }
                if(nameWire2 != null){
                    this.$wire.set(nameWire2, this.value)
                }                                
                if(nameWire3 != null){
                    this.$wire.set(nameWire3, this.value)
                }                                
                
                this.isOpen=false;
                return;
            }
           
            @this.emit('{{$event}}',item,this.search);

           

            {{-- console.log(item); --}}
            
            if(this.noClose){
                return;
            }
            
            this.value=item.id;
            this.search=item.name;


            element = $refs.ref_value
            element.value=item.id;
            nameWire =element.getAttribute('wire:model') ;
            nameWire2 =element.getAttribute('wire:model.defer') ;
            nameWire3 =element.getAttribute('wire:model.lazy') ;
            if(nameWire != null){
                this.$wire.set(nameWire, this.value)
            }
            if(nameWire2 != null){
                this.$wire.set(nameWire2, this.value)
            }                                
            if(nameWire3 != null){
                this.$wire.set(nameWire3, this.value)
            }                                
            
            this.close();
              
            

        },
        selectItem2:function(item){
            this.value=item.id;
            this.search=item.name;
            this.close();
        },
        setSearch:function(event){
            
            try{
                element = $refs.ref_value
                search  = this.collection.find(function(item){
                    if(item.id == element.value){
                        return item.name;
                    }
                });
                this.search=search.name;
            }catch(e){
                if(this.noClose){
                   
                }else{
                    this.search='';
                }
               
            }
        },
      
        setWidth:function(){
            try{
                width = $refs.ref_search.clientWidth ;
                $refs.ref_items.style.width=width + 'px';
            }catch(e){}           
        },
        setPosition:function(){
            height = $refs.ref_search.clientHeight ;
            {{-- console.log('height' , height); --}}
        },
        effect:function(){
            try{
                this.setSearch();
                if(this.isOpen){
                    this.setWidth();
                    this.setPosition();
                }
               
            }catch(e){}

            
        },
        open:function(){
            this.isOpen=true;
            this.setWidth();
        },
        setItemToNull:function(){
            this.close();
            this.search='';
        },
        close:function(){
            console.log(this.noClose);
            if(this.noClose){
            
            }else{

                this.isOpen=false;
            }
        },

    }" ,
    
    x-effect="effect()"
    x-on:resize.window="setWidth()"
    {{-- x-on:scroll.window.child="setPosition()" --}}
>
    <input placeholder="{{$placeholder}}" type="search" x-ref="ref_search" x-on:focus="open()" x-on:keyup="open()" x-model="search" class="w-full rounded border border-gray-200 outline-none">
    <input type="hidden" x-ref="ref_value"   {{ $attributes->merge(['class' => '']) }}> 
    
 
    <div x-cloak x-show="isOpen"  class="absolute rounded shadow bg-white  overflow-auto border border-blue-200 z-10" style="max-height: {{$height}}"  x-transition.scale.10.origin.top.duration.600>
        <div x-ref="ref_items" >
           <ul class="text-gray-400">
                <li class="hover:bg-gray-100 p-1 cursor-pointer" x-on:click="selectItem(null)" >
                    <div class="block px-4 py-2 text-sm text-gray-500 hover:text-gray-900">{{$placeholder}}</div>
                </li>
                <template x-for="(item, index) in getCollection" >
                    <li class="hover:bg-gray-100 p-1 cursor-pointer" x-on:click="selectItem(item)" >
                            <div class="block px-4 py-2 text-sm text-gray-500 hover:text-gray-900" x-text="item.name" tabindex="-1"></div>
                    </li>
                </template>
                
              
           </ul>
        </div>
    </div>
</div>