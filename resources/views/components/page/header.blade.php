@props(["title"=>null,"label"=>null])
<div class="page-header">
    <div class="flex-none">
        <span class="title">{{$title}}</span>
        <span class="label">{{$label}}</span>
    </div>
    <ul class="breadcrumb">
        @foreach(LForm::getBreadcrumb() as $item)
            <li class="item">
                <a href="{{$item->url}}" title="{{$item->name}}">{{$item->name}}</a>
            </li>
        @endforeach
    </ul>
</div>
