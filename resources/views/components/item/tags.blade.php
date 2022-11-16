@props(['params'=>[]])
<div class="tags">
    @if($params)
        @foreach($params as $key =>$value)
            <span class="item">{{$value}}</span>
        @endforeach
    @endif
</div>
