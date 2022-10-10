@props(["name","label"=>null,"class"=>null,"params"=>[] ])
<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <div class="lf-flex">
        @foreach($params as $k=>$title)
            <label class="item"><input class="form-checkbox" type="checkbox" wire:model="{{$name}}" value="{{$k}}" /> <span class="text">{{$title}}</span></label>
        @endforeach
    </div>
</x-lf.form.field>
