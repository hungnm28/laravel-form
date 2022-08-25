@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"rows"=>"5","model"=>".debounce.300ms"])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <textarea  wire:model{{$model}}="{{$name}}" id="lf-{{$name}}" placeholder="{{$placeholder}}" class="form-input" rows="{{$rows}}" {{$attributes}} ></textarea>
</x-lf.form.field>
