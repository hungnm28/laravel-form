@props(["name","label"=>null,"class"=>null ])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <div class="lf-flex">
        <label class="item"><input class="form-radio" type="radio" wire:model="{{$name}}" value="1" /> <span class="text">Form radio 1</span></label>
        <label class="item"><input class="form-radio" type="radio"  wire:model="{{$name}}" value="2" /> <span class="text">Form radio 1</span></label>
    </div>
</x-lf.form.field>
