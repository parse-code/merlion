<div {{$attributes}}>
    @foreach($getComponents() as $component)
        <div {{ $component->getAttributes('wrapper')->merge($getAttributes('items')->toArray())}}>
            {!! render($component) !!}
        </div>
    @endforeach
</div>
