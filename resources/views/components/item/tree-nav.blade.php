@props(["item"=>[], "key", "route"])
<div class="item">
    <div key="{{$key}}" class="item-content">
        <span class="p-2 flex-none flex items-start" title="Icon">{!! lfIcon($item["icon"]) !!}</span>
        <span class="flex-auto flex flex-wrap pl-1 py-2 border-l">
            <b class=" pl-1 flex-none" title="Label">{{$item["label"]}}</b>
            <span class="pl-1 flex-none" title="Route Name">({{$item["route"]}})</span>
            <span class=" pl-1 flex-auto text-red-700" title="Permission">{{$item['permission']}}</span>
        </span>

        <span class="tools">
             <span class="btn-danger xs" wire:click="delete('{{$key}}')">{!! lfIcon("delete",11) !!}</span>
        </span>
    </div>

    @if(isset($item["children"]))
        <div class="tree">
            @foreach($item['children'] as $k=> $child)
                <x-lf.item.tree-nav key="{{$key}}.{{$k}}" :item="$child" :route="$route"/>
            @endforeach
        </div>
    @endif
</div>
