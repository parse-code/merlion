@if($label = $getLabel())
    <label class="text-muted">{{$label}}</label>
@endif
<div {{$attributes}} id="{{$getId()}}"></div>
<template id="content_{{$getId()}}">{!! $getValue() !!}</template>

@pushonce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/markdown-it@14.1.0/dist/markdown-it.min.js"></script>
@endpushonce
@push('after_scripts')
    <script>
        (function() {
            let md = window.markdownit({
                html: true,        // 启用 HTML 标签支持
                linkify: true,     // 自动识别链接
                typographer: true  //
            });
            var result = md.render(document.getElementById('content_{{$getId()}}').innerHTML); // parsed is a 'Node' tree
            document.getElementById('{{$getId()}}').innerHTML = result;

            $('#{{$getId()}} img').each(function () {
                let link = $(this).attr('src');
                if (link.startsWith('https://glama.ai')) {
                    $(this).attr('src', '/proxy?url=' + $(this).attr('src'));
                }
            });
        })();
    </script>
@endpush
