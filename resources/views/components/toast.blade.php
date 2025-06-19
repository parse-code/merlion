<script nonce="{{panel()->getNonce()}}">
    @if($message = panel()->getMessage())
    admin().toast({
        text: "{{$message}}",
        className: "{{session()->get('toast.type', 'success')}}",
        position: '{{session()->get('toast.position', 'center')}}'
    })
    @endif
</script>
