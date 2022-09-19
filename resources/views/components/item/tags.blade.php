@props(['params'=>[]])
<div class="tags">
    @if(is_array($params))
        @foreach($params as $key =>$value)
            <span class="item">{{$value}}</span>
        @endforeach
    @endif
</div>
