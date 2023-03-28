@props(["name","label"=>null,"class"=>null,"params"=>[],"default"=>[]])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <select class="form-input" wire:model="{{$name}}" id="lff-{{$name}}" {{$attributes}} >
        @foreach($default as $k => $val)
            <option value="{{$k}}">{{$val}}</option>
        @endforeach
        @foreach($params as $k => $param)
            <optgroup label="{{$param["label"]}}">
                @foreach($params["children"] as $kC =>$child)
                    <option value="{{$kC}}">{{$child}}</option>
                @endforeach
            </optgroup>

        @endforeach
    </select>
</x-lf.form.field>
