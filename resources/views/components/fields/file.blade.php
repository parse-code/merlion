@php
    $files = [];
    $name = $getName();
    if($isMultiple()) {
        $name = $name.'[]';
        $files = to_json($getValue())??[];
    } else {
        if($value = $getValue()) {
            $files = [$value];
        }
    }
@endphp
<label for="{{$getId()}}">{{ $getLabel()}}</label>
<input type="file" id="{{$getId()}}"
       @if($isMultiple())  multiple @endif
       {{$attributes->merge(['class' => 'form-control'])}}
       name="{{$name}}" {{$attributes}}>

<!--preview-->
<div data-simplebar class="mt-2">
    <ul class="list-group">
        @foreach($files as $file)
            <li class="list-group-item">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="d-flex">
                            <div class="flex-shrink-0 avatar-xs">
                                <div class="rounded">
                                    <img src="{{$file}}" alt="" height="30">
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <input type="hidden" name="old_{{$name}}" value="{{$file}}">
                        <a data-remove-file role="button" class="text-danger"><i
                                class="ri-delete-bin-line"></i></a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>

@pushonce('scripts')
    <script>
        $('[data-remove-file]').on('click', function () {
            $(this).parents('li').remove();
        });
    </script>
@endpushonce
