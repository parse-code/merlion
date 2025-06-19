@php
    $header = $getHeader();
    $body = $getBody();
    $footer = $getFooter();
@endphp

<div class="card">
    @if(!empty($header))
        <div {{$getAttributes('header')->merge(['class'=>'card-header'])}}>
            {!! render($header) !!}
        </div>
    @endif
    @if(!empty($body))
        <div {{$getAttributes('body')->merge(['class'=>'card-body'])}}>
            {!! render($body) !!}
        </div>
    @endif
    @if(!empty($footer))
        <div {{$getAttributes('footer')->merge(['class'=>'card-footer'])}}>
            {!! render($footer) !!}
        </div>
    @endif
</div>
