@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"type"=>"text","params"=>[], "datalist"=>[]])

<x-lf.form.field :name="$name" :label="$label" :class="$class . ' form-array'">
    <div x-data="{ key: '', val: '', addJson() {
            if(this.key !='' && this.val !=''){
                $wire.addJson('{{$name}}',this.key, this.val);
                this.key='';
                this.val='';
            }
        } }" class="form-tags">
        <div class="tags">
            @foreach($params as $k=>$val)
                <span class="tag"><span class="text">{{$k}} : {{$val}}</span><label class="icon" wire:click="removeItem('{{$name}}','{{$k}}')">{!! lfIcon("close",11) !!}</label></span>
            @endforeach
        </div>
        <div class="item-add w-full flex">
            <div class="w-full md:w-1/2 pr-1">
                <input type="text" x-model="key" placeholder="Key ..." class="form-input" @keyup.enter="addJson"  />
            </div>
            <div class="w-full md:w-1/2 flex" >
                <input type="text" x-model="val" placeholder="Value ..." class="form-input" @keyup.enter="addJson" @if($datalist) list="lff-list-{{$name}}" @endif />
                <label wire:loading.attr="disabled" class="icon" @click="addJson">{!! lfIcon("add",15) !!}</label>
            </div>
        </div>
        @if($datalist)
            <datalist id="lff-list-{{$name}}">
                @foreach($datalist as $dt)
                    <option  value="{{$dt}}">
                @endforeach
            </datalist>
        @endif
    </div>
</x-lf.form.field>
