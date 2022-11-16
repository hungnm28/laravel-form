@props(["name","class"=>"btn"])
<label class="{{$class}}" x-data="{}" @click="$dispatch('{{$name}}')" {{$attributes}}>{{$slot}}</label>
