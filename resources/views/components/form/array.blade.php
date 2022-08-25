@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"type"=>"text","params"=>[]])

<x-lf.form.field :name="$name" :label="$label" :class="$class . ' form-array'">
    <div x-data="{ val: '', addItem() {
            $wire.addItem('{{$name}}',this.val);
            this.val='';
        } }" class="flex flex-col-reverse">

        <div class="item-add w-full"
        >
            <input x-model="val" id="lf-add-{{$name}}" type="{{$type}}" @keyup.enter="addItem"
                   placeholder="{{$placeholder}}" {{$attributes}} class="form-input input-array"/>
            <label wire:loading.attr="disabled" class="icon" @click="addItem">{!! lfIcon("add",18) !!}</label>
        </div>
        <div class="w-full flex-none">
            @foreach($params as $k=> $param)
                <div class="item">
                    <input type="{{$type}}" wire:model="{{$name}}.{{$k}}" placeholder="{{$placeholder}}"
                           class="form-input input-array"/>
                    <label class="icon" wire:click="removeItem('{{$name}}',{{$k}})">{!! lfIcon("close",12) !!}</label>
                </div>
            @endforeach
        </div>
    </div>
</x-lf.form.field>
