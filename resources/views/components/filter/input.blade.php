@props(["name","type"=>"text","model"=>".debounce.300ms"])
<div class="field">
    <input class="form-input" type="{{$type}}" wire:model{{$model}}="{{$name}}" {{$attributes}} />
</div>
