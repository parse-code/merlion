<div class="card card-animate">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <p class="fw-medium text-muted mb-0">{{$getTitle()}}</p>
                @if($link = $getLink())
                    <a href="{{$link}}" target="{{$getTarget()}}">
                @endif
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        {{$getContent()}}
                    </h2>
                @if($link)
                    </a>
                @endif
                {!! render($getComponents('bottom')) !!}
            </div>
            @if($icon = $getIcon())
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-{{$getColor()}}-subtle rounded fs-3 material-shadow">
                        <i class="{{$icon}} text-{{$getColor()}}"></i>
                    </span>
                </div>
            @endif
        </div>
    </div><!-- end card body -->
</div>
