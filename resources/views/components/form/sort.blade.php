@props(["name","value"=>0])
<label class="form-sort" wire:click="postSort('{{$name}}')">
    <span class="label">{{$slot}}</span>
    @switch($value)
        @case(1)
            <span class="icon">{!! lfIcon("sort-asc",14) !!}</span>
            @break
        @case(2)
            <span class="icon">{!! lfIcon("sort-desc",14) !!}</span>
            @break
        @default
            <span class="icon">{!! lfIcon("sort",14) !!}</span>
    @endswitch
</label>
