@if($label = $getLabel())
    <label class="text-muted">{{$label}}</label>
@endif
<div class="d-flex gap-1 flex-wrap">
    @foreach($getValue() as $value)
        <img src="{{$value}}" {{$attributes}}
        @if($height = $getHeight())  height="{{$height}}" @endif
             @if($width = $getWidth())  width="{{$width}}" @endif
        >
    @endforeach
</div>
