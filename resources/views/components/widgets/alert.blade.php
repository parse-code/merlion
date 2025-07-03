@if($content = panel()->getAlert())
    admin().toast({
    text: "{{$message}}",
    className: "{{session()->get('toast.type', 'success')}}",
    position: '{{session()->get('toast.position', 'center')}}'
    })
    @php
        $type = session()->get('alert.type', 'success');
    @endphp
    <div class="alert alert-{{$type}}">
        {{$content}}
    </div>
@endif
