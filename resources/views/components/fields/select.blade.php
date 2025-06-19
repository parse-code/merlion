@php
    use Illuminate\Support\Collection;$options = $getOptions();
    $name = $getName();
    $value = $getValue();
    if($isMultiple()) {
        $name = $name.'[]';
        if($value instanceof Collection) {
            $value = $value->toArray();
        }
    }
@endphp

<label for="{{$getId()}}">{{$getLabel()}}</label>
<select name="{{$name}}" id="{{$getId()}}"
        @if($isMultiple()) multiple @endif
    {{$attributes->merge(['class'=>'form-select'])}}>
    @if($isAllowEmpty())
        <option value="">-</option>
    @endif
    @foreach($options as $_key => $_label)
        <option value="{{$_key}}"
                @if($isMultiple())
                    @if(in_array($_key,$value??[])) selected @endif
                @else
                    @if($_key == $value) selected @endif
            @endif
        >{{$_label}}</option>
    @endforeach
</select>
@pushonce('scripts')
    <script src="{{panel()->asset('libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
@endpushonce
@pushonce('styles')
    <link rel="stylesheet" href="{{panel()->asset('libs/choices.js/public/assets/styles/choices.min.css')}}">
    <style>
        .choices {
            min-width: 150px !important;
        }
    </style>
@endpushonce
@push('scripts')
    <script>
        (function () {
            new Choices('#{{$getId()}}', {
                removeItemButton: true,
            });
        })();
    </script>
@endpush
