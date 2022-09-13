@props(["name","sName","label","value"=>0,"fields"=>[]])
@if(data_get($fields,"$name.status"))
    <th><x-lf.form.sort name="{{$sName}}" :value="$value">{{$label}}</x-lf.form.sort></th>
@endif
