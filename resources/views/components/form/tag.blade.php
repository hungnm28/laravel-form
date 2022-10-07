@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"type"=>"text","params"=>[],"datalist"=>null])

<x-lf.form.field :name="$name" :label="$label" :class="$class . ' form-array'">
    <div x-data="{ val: '', addItem() {
            $wire.addItem('{{$name}}',this.val);
            this.val='';
        } }" class="form-tags">
        <div class="tags">
            @foreach($params as $k=>$val)
                <span class="tag"><span class="text">{{$val}}</span><label class="icon" wire:click="removeItem('{{$name}}',{{$k}})">{!! lfIcon("close",11) !!}</label></span>
            @endforeach
        </div>
        <div class="tag-add">
            <input @if($datalist) list="lff-list-{{$name}}" @endif  x-model="val" id="lff-add-{{$name}}" type="{{$type}}" @keyup.enter="addItem" placeholder="{{$placeholder}}" {{$attributes}} class="form-input input-array" />
            <label wire:loading.attr="disabled" class="icon" @click="addItem">{!! lfIcon("add",15) !!}</label>
            @if($datalist)
                <datalist id="lff-list-{{$name}}">
                    @foreach($datalist as $dt)
                    <option  value="{{$dt}}">
                    @endforeach
                </datalist>
            @endif
        </div>
    </div>
</x-lf.form.field>
