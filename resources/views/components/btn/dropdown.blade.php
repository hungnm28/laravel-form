@props(["icon","class"=>"","iSize"=>18])
<div x-data="{open: false}" class="lf-dropdown {{$class}}" :class="open?'active':''" >
    <label class="icon" @click="open = !open">{!! lfIcon($icon,$iSize) !!}</label>
    <div x-show="open"  @click.away="open = false" class="box-dropdown" style="display: none">
       {{$slot}}
    </div>
</div>
