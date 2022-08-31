@props(['params'=>[]])
<div class="tags">
    @foreach($params as $key =>$value)
        <span class="item">{{$value}}</span>
    @endforeach
</div>
