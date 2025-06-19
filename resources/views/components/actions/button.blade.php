<button {{$attributes}}>
    @if($isIconStart())
        @include('merlion::components.icon', ['icon' => $getIcon()])
    @endif
    {{$getLabel()}}
    @if(!$isIconStart())
        @include('merlion::components.icon', ['icon' => $getIcon()])
    @endif
</button>
