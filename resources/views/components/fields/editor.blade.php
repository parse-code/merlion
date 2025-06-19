<!-- Include stylesheet -->

<!-- Create the editor container -->
<label for="{{$getId()}}">{!! $getLabel() !!}</label>
<textarea {{$attributes->merge(['class'=>'form-control'])}}
    id="{{$getId()}}"
    name="{{$getName()}}">{!! $getValue() !!}</textarea>

@if($isRich())
@pushonce('scripts')
    <script src="https://unpkg.com/tinymce@7.9.0/tinymce.js"></script>
@endpushonce
@push('after_scripts')
    <script>
        $(function () {
            @php
                $options = array_merge([
                    "selector" => 'textarea#'.$getId(),
                    "plugins"=> 'image',
                    "images_upload_url" => panel()->route('api.upload'),
                    "license_key" => 'gpl',
                ], $getOptions());
            @endphp
            tinymce.init(@json($options));
        });
    </script>
@endpush
@endif
