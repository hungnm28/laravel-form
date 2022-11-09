@props(["class"=>null, "footer"=>null])
<div class="small-box {{$class}}">
    <div class="content">
        {{$slot}}
    </div>
    @if($footer)
        <div class="footer">
            {{$footer}}
        </div>
    @endif
</div>
