@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"rows"=>"5","model"=>".lazy"])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <textarea  wire:model{{$model}}="{{$name}}" id="lff-{{$name}}" placeholder="{{$placeholder}}" class="form-input" rows="{{$rows}}" {{$attributes}} ></textarea>
</x-lf.form.field>
