@props(["class"=>'',"params"=>['Listing','Create','Show','Edit']])
<div class="form-finished {{$class}}">
    <span class="label">Go to:</span>
    <div class="flex w-full flex-wrap pb-3 pt-1">
        @foreach($params as $k=>$title)
            <label class="item">
                <input type="radio" wire:model="done" value="{{$k}}" />
                <span class="title">{{$title}}</span>
            </label>
         @endforeach
    </div>
</div>
