 <i role="button" class="ri-clipboard-line" data-copy data-content="{{$content??''}}"></i>
@pushonce('scripts')
    <script>
        $('[data-copy]').click(function () {
            let content = $(this).data('content');
            admin().copyToClipboard(content);
            $(this).addClass('text-success');
            $(this).tooltip({
                title: 'Copied',
                placement: 'top'
            }).tooltip('show');
        });
    </script>
@endpushonce
