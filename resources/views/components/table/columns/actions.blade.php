<div class="btn-group">
    @foreach($getComponents() as $component)
        {!! render($component) !!}
    @endforeach
</div>
