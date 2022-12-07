@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"type"=>"text","params"=>[],"datalist"=>null])

<x-lf.form.field :name="$name" :label="$label" :class="$class . ' form-array'">
    <div x-data="{ val: '', addItem() {
            $wire.addItem('{{$name}}',this.val);
            this.val='';
        } }" class="flex flex-col-reverse">

        <div class="item-add w-full"
        >
            <input x-model="val" id="lff-add-{{$name}}" type="{{$type}}" @keyup.enter="addItem" placeholder="{{$placeholder}}" {{$attributes}} class="form-input input-array" @if($datalist) list="lff-list-{{$name}}" @endif />
            <label wire:loading.attr="disabled" class="icon" @click="addItem">{!! lfIcon("add",15) !!}</label>
        </div>
        <div class="w-full flex-none">
            @foreach($params as $k=> $param)
                <div class="item">
                    <input type="{{$type}}" wire:model="{{$name}}.{{$k}}" placeholder="{{$placeholder}}" class="form-input input-array" />
                    <label class="icon" wire:click="removeItem('{{$name}}',{{$k}})">{!! lfIcon("close",12) !!}</label>
                </div>
            @endforeach
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
