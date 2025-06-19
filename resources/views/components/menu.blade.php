@php
    $nest = false;
    $sub_menus = $getComponents();
    if(!empty($sub_menus)) {
        $nest = true;
    }
@endphp

@if($isTitle())
    <li class="menu-title">
        <span>{!! $getLabel() !!}</span>
    </li>
@else
    <li class="nav-item">
        <a
            @if($nest)
                href="#{{$getId()}}" data-bs-toggle="collapse" role="button" aria-expanded="false"
            @else
                href="{{$getLink()}}"
            @endif
            class="nav-link menu-link">
            @if($icon = $getIcon())
                <i class="{{$icon}}"></i>
            @endif
            <span>{{$getLabel()}}</span>
        </a>
        @if(!empty($sub_menus))
            <div class="collapse menu-dropdown" id="{{$getId()}}">
                <ul class="nav nav-sm flex-column">
                    @foreach($sub_menus as $sub_menu)
                        {!! render($sub_menu) !!}
                    @endforeach
                </ul>
            </div>
        @endif
    </li>
@endif
