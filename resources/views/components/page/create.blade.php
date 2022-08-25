@props(["title"=>null,"class"=>"info max-w-4xl","route"=>null])
<div class="w-full p-4">
    <x-lf.card title="Create" class="{{$class}}">
        {{$slot}}
        @if($route)
            <x-slot name="tools">
                <a class="btn-primary sm" href="{{route($route)}}">{!! lfIcon("list") !!}</a>
            </x-slot>
        @endif
        <x-slot name="footer">
            <div class="card-footer">
                <span></span>
                <div class="flex">
                    <div class="flex-none">
                        <label class="btn-primary" wire:click="store">Create</label>
                    </div>
                    <div class="flex-auto flex space-x-4 px-4">
                        <label class="flex-none flex items-center">
                            <input type="radio" wire:model="done" class="form-radio form-confirm mr-1" value="0"/>
                            <span>Listing</span>
                        </label>
                        <label class="flex-none flex items-center">
                            <input type="radio" wire:model="done" class="form-radio form-confirm mr-1" value="1"/>
                            <span>Create</span>
                        </label>
                        <label class="flex-none flex items-center">
                            <input type="radio" wire:model="done" class="form-radio form-confirm mr-1" value="2"/>
                            <span>Show</span>
                        </label>
                        <label class="flex-none flex items-center">
                            <input type="radio" wire:model="done" class="form-radio form-confirm mr-1" value="3"/>
                            <span>Edit</span>
                        </label>
                    </div>
                    <div class="flex-none">
                        <label class="btn" wire:click="resetForm">Cancel</label>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-lf.card>
</div>
