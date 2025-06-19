<!-- Default Modals -->
<div type="button" id="btn_{{$getId()}}">
    {!! render($getButton()) !!}
</div>

<div id="{{$getId()}}" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$getTitle()}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="errors_{{$getId()}}" class="alert alert-danger " style="display:none;"></div>
                <div id="lazy_content_{{$getId()}}"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function () {
            admin().lazyForm({
                id: "{{$getId()}}",
                url: '{!! $getContentUrl() !!}'
            });
        });
    </script>
@endpush
