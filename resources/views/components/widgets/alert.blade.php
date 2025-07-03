@if($content = panel()->getAlert())
    @php
        $type = session()->get('alert.type', 'success');
    @endphp
    <div class="alert alert-{{$type}}">
        {{$content}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
