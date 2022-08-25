@props(["name","label"=>null,"class"=>null ])
<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <div class="lf-flex">
        <label class="item"><input class="form-checkbox" type="checkbox" wire:model="{{$name}}" value="1" /> <span class="text">Form checkbox 1</span></label>
    </div>
</x-lf.form.field>
