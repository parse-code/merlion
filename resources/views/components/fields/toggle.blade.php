@php
    $class = 'form-check-input';
    if($errors->has($getName())) {
        $class .=' is-invalid';
    }
@endphp
<label for="{{$getId()}}">{!! $getLabel() !!}</label>
<div class="form-check form-switch">
    <input type="checkbox"
           id="{{$getId()}}"
           name="{{$getName()}}"
           value="on"
           @if($getValue()) checked @endif
        {{$attributes->merge(['class' => $class])}}
    >
</div>
