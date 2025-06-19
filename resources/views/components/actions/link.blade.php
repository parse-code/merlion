<a {{$attributes}} target="{{$getTarget()}}" href="{{$getLink()}}">
    @if($isIconStart())
        @include('merlion::components.icon', ['icon' => $getIcon()])
    @endif
    {{$getLabel()}}
    @if(!$isIconStart())
        @include('merlion::components.icon', ['icon' => $getIcon()])
    @endif
</a>
