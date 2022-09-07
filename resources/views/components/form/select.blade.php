@props(["name","label"=>null,"class"=>null,"params"=>[],"default"=>[]])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <select class="form-input" wire:model="{{$name}}" id="lf-{{$name}}" {{$attributes}} >
        @foreach($default as $k => $val)
            <option value="{{$k}}">{{$val}}</option>
        @endforeach
        @foreach($params as $k => $param)
            <option value="{{$k}}">{{$param}}</option>
        @endforeach
    </select>
</x-lf.form.field>
