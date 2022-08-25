@props(["title"=>null,"class"=>"secondary max-w-4xl","route"=>null,"tools"=>null])
<div class="w-full p-4">
    <x-lf.card title="Edit" class="{{$class}}">
        {{$slot}}
        @if($tools)
            <x-slot name="tools">
                {{$tools}}
            </x-slot>
        @endif
        <x-slot name="footer">
            <div class="card-footer">
                <span></span>
                <div class="flex">
                    <div class="flex-none">
                        <label class="btn-primary" wire:click="store">Update</label>
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
                    </div>
                    <div class="flex-none">
                        <label class="btn-warning" wire:click="resetForm">Reset</label>
                        <label class="btn" wire:click="resetForm">Cancel</label>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-lf.card>
</div>
