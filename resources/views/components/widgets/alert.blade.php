@if($content = panel()->getAlert())
    @php
        $type = session()->get('alert.type', 'success');
    @endphp
    <div class="alert alert-{{$type}}">
        {{$content}}
    </div>
@endif
