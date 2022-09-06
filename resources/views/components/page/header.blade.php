<div id="lf-header">
    <span class="lf-title">{{lForm()->getTitle()}}</span>
    <ul class="breadcrumb">
        @foreach(lForm()->getBreadcrumb() as $item)
            <li class="item">
                <a href="{{$item->url}}" title="{{$item->name}}">{{$item->name}}</a>
                <span>\</span>
            </li>
        @endforeach
    </ul>
</div>
