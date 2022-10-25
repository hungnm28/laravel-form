@props(["name","label"=>null,"class"=>null,"placeholder"=>null,"type"=>"text","model"=>".debounce.300ms",'datalist'=>null])

<x-lf.form.field :name="$name" :label="$label" :class="$class">
    <div class="form-group">
        {{$slot}}
    </div>
</x-lf.form.field>
