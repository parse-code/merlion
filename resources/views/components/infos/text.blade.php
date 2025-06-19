@php
    $value = $getValue();
@endphp

@if($label = $getLabel())
    <label class="text-muted">{{$label}}</label>
@endif
<div {{$attributes}}>
    @if($getLink())
        <a href="{{$getLink()}}" target="{{$getTarget()}}">
            {!! $value !!}
        </a>
    @else
        {!! $value !!}
    @endif
    @if($isCopyable())
        @include('merlion::components.scripts.copyable', ['content' => to_string($value)])
    @endif
</div>

