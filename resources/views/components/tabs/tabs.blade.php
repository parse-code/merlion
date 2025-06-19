<ul class="nav nav-tabs" role="tablist">
    @foreach($getTabs() as $tab)
        <li class="nav-item" role="presentation">
            <a class="nav-link {{$loop->first ? 'active':''}}"
               @if($link = $tab->getLink())
                   href="{{$link}}" target="{{$tab->getTarget()}}"
               @else
                   data-bs-toggle="pill" data-bs-target="#{{$tab->getId()}}" type="button"
               @endif
               role="tab">{{$tab->getLabel()}}
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content">
    @foreach($getTabs() as $tab)
        <div class="tab-pane {{$loop->first ? 'active show':''}}" id="{{$tab->getId()}}" role="tabpanel">
            {!! render($tab) !!}
        </div>
    @endforeach
</div>
