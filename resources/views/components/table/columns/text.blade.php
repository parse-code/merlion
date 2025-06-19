@php
    $value = $getValue();
@endphp
<div {{$attributes}}>
    @if($link = $getLink())
        <a href="{{$link}}" target="{{$getTarget()}}">{!!$value!!}</a>
    @else
        {!! $value !!}
    @endif
    @if($isCopyable())
        @include('merlion::components.scripts.copyable', ['content' => to_string($value)])
    @endif
</div>


