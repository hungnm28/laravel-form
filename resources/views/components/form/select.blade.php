@props(["name","label"=>null,"class"=>null,"params"=>[]])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <select class="form-input" wire:model="{{$name}}" id="lf-{{$name}}" {{$attributes}} >
        @foreach($params as $k => $param)
            <option value="{{$k}}">{{$param}}</option>
        @endforeach
    </select>
</x-lf.form.field>
