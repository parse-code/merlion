<form action="{{$getAction()}}" method="{{$getMethod() == 'get' ? 'get':'post'}}" {{$attributes}}>
    @csrf
    @method($getMethod())
    @include('merlion::components.errors')
    {!! render($getFields()) !!}
</form>
