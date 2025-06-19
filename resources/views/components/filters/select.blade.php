<select name="{{$getName()}}" {{$attributes->merge(['class' => 'form-select'])}}>
    <option value="">-- {{$getLabel()}} --</option>
    @foreach($getOptions() as $_value => $_label)
        <option
            value="{{$_value}}"
            @if(to_string($_value) == to_string($getValue()))
                selected
            @endif
        >{{$_label}}
        </option>
    @endforeach
</select>
