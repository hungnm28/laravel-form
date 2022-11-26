@props(['name'=>null,'label'=>null,'class'=>null])

<div class="form-field {{$class}}">
    @if($label)
        <label for="lff-{{$name}}" class="form-label">{{$label}}</label>
    @endif
    <div class="form-box">
        {{$slot}}
    </div>
</div>
