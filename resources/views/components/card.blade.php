@props(['title'=>null,'class'=>'primary full', 'tools'=>null,'footer'=>null])
<div class="card {{$class}}">
    <div class="card-header">
        <span class="title">{{$title}}</span>
        <span class="flex-1"></span>
        @if($tools)
            <div class="card-tools">{{$tools}}</div>
        @endif
    </div>
    <div class="card-content">
        {{$slot}}
        @if($footer)
            {{$footer}}
        @endif
    </div>
</div>
