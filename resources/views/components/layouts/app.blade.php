<!doctype html>
<html lang="en" {{panel()->getAttributes('html')}}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="csp-nonce" content="{{panel()->getNonce()}}">
    <title>{{panel()->getPageTitle()}} | {{panel()->getBrandName()}}</title>
    @stack('before_styles')
    @stack('styles')
    @foreach(panel()->getCss() as $css)
        {!! render($css->withAttributes(['nonce' => panel()->getNonce()])) !!}
    @endforeach
    @stack('after_styles')
</head>
<body {{$attributes}}>
{{$slot}}
<div id="body-img"></div>
@stack('body')
@stack('before_scripts')
@foreach(panel()->getScripts() as $script)
    {!! render($script->withAttributes(['nonce' => panel()->getNonce()])) !!}
@endforeach
@stack('scripts')
@stack('after_scripts')
@include('merlion::components.toast')
</body>
</html>
