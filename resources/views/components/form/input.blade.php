@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"type"=>"text","model"=>".debounce.300ms"])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <input class="form-input" type="{{$type}}" wire:model{{$model}}="{{$name}}" id="lf-{{$name}}" placeholder="{{$placeholder}}" {{$attributes}} />
</x-lf.form.field>
