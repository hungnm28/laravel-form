@props(["class"=>"primary","fields"=>[],"filters"=>null,"footer"=>null,"tools"=>null])
<div class="w-full p-0" x-data="{ filter: false}">
    <x-lf.card title="Listing" class="{{$class}} min-h-screen">
        @if($filters)
            <div class="form-filter" x-show="filter" style="display: none">
                <x-lf.filter.label>Filter:</x-lf.filter.label>
                {!! $filters !!}
            </div>
        @endif
        {{$slot}}
        <x-slot name="tools">
            @if($filters)
                <div><a class="btn-info sm" @click="filter= !filter">{!! lfIcon("filter",14) !!}</a></div>
            @endif
            @if($tools)
                {!! $tools !!}
            @endif
            <div class="relative" x-data="{fields: false}">
                <label @click="fields = !fields" class="btn-danger sm">{!! lfIcon("list",14) !!}</label>
                <div x-show="fields" @click.away="fields=false" style="display: none"
                     class="absolute right-0 bg-white rounded shadow-2xl max-h-60 overflow-auto text-slate-700 z-40">
                    @foreach($fields as $k =>$field)
                        <label class="flex items-center p-2 px-4 border-b last:border-none text-sm">
                            <input type="checkbox" class="mr-1" wire:model="fields.{{$k}}.status"/>
                            <span class="whitespace-nowrap text-slate-700">{{$field['label']}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <x-slot name="footer">
                <div class="card-footer"> {!! $footer !!}</div>
            </x-slot>
        </x-slot>

    </x-lf.card>
</div>
