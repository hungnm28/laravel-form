@props(['val'=>0])
<label class="lf-toggle">
    <input type="checkbox" class="hidden toggle" value="1" {{$val==1? 'checked' : ''}} {{$attributes}} />
    <span class="bar"><span class="dot"></span></span>
</label>
