@props(['name','label'=>null,'class'=>null])

<div id="lff-form-{{$name}}" class="form-field {{$class}} @error($name) error @enderror">
    @if($label)
        <label for="lff-{{$name}}" class="form-label">{{$label}}</label>
    @endif
    <div class="form-box">
        {{$slot}}
        @error($name)
        <label class="message" for="lf-{{$name}}">{{$message}}</label>
        @enderror
    </div>
</div>
