@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"type"=>"text","model"=>".debounce.300ms",'datalist'=>null])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <input @if($datalist) list="lff-list-{{$name}}" @endif class="form-input" type="{{$type}}" wire:model{{$model}}="{{$name}}" id="lff-{{$name}}" placeholder="{{$placeholder}}" {{$attributes}} />
    @if($datalist)
        <datalist id="lff-list-{{$name}}">
            @foreach($datalist as $dt)
                <option  value="{{$dt}}">
            @endforeach
        </datalist>
    @endif
</x-lf.form.field>
