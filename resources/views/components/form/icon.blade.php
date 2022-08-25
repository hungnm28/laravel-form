@props(["name","label"=>null,"class"=>null,"val"=>null])
@php
    $icons = [];
    $path = public_path('assets/images/icons.svg');
    if(file_exists($path)){
            $str = file_get_contents($path);
            $icons = [];
            if (preg_match_all('/id=\"([a-z0-9-]*)\"/', $str, $arr)) {
                $icons = $arr[1];
            }
    }
@endphp
<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <div x-data="{open : false}" class="form-icon">
        <label @click="open=!open" class="btn-primary">@if($val) <span class="icon">{!! lfIcon($val) !!}</span> <span class="text">{{$val}}</span> @else Icon @endif</label>
        <div x-show="open" @click.away="open = false" style="display: none" class="box-icons">
            <div class="icons">
                @foreach($icons as $ic)
                    <label @click="open = false" class="item">
                        <input type="radio" class="hidden" wire:model="{{$name}}" value="{{$ic}}">
                        <span class="item-show @if($ic == $val)active @endif">
                            <span class="icon">{!! lfIcon($ic,22) !!}</span>
                            <span class="text">{{$ic}}</span>
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</x-lf.form.field>

