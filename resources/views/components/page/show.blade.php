@props(["title"=>"Show","class"=>"success","tools"=>null])
<div class="w-full p-4">
    <x-lf.card :title="$title" class="{{$class}}">
        {{$slot}}
        @if($tools)
            <x-slot name="tools">
                {{$tools}}
            </x-slot>
        @endif
    </x-lf.card>
</div>
