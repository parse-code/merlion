<th>
    {!! $getContainer()->getLabel() !!}
    @if($getContainer()->isSortable())
        @if(request('sort_by') != $getContainer()->getName())
            <a class="text-muted" href="?sort_by={{$getContainer()->getName()}}&sort_type=asc">
                <i class="bx bx-sort"></i>
            </a>
        @else
            @if(request('sort_type') == 'desc')
                <a href="?sort_by={{$getContainer()->getName()}}&sort_type=asc">
                    <i class="ri-arrow-down-line"></i>
                </a>
            @else
                <a href="?sort_by={{$getContainer()->getName()}}&sort_type=desc">
                    <i class="ri-arrow-up-line"></i>
                </a>
            @endif
        @endif
    @endif
</th>
