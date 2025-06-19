@php
    $class = 'form-control';
    if($errors->has($getName())) {
        $class .=' is-invalid';
    }
@endphp
<label for="{{$getId()}}">{!! $getLabel() !!}</label>
<input type="{{$getType()}}"
       id="{{$getId()}}"
       name="{{$getName()}}"
       value="{{old($getName(), $getValue())}}"
    {{$attributes->merge(['class' => $class])}}
>
