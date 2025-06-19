<div class="dropdown ms-1 topbar-head-dropdown header-item">
    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if($lang = panel()->getCurrentLanguage())
            <img id="header-lang-img" src="{{panel()->asset('/images/flags/'.$lang.'.svg')}}" alt="Header Language" height="20" class="rounded">
        @else
        <i class="ri-translate fs-22"></i>
        @endif
</button>
<div class="dropdown-menu dropdown-menu-end">

@foreach(config('merlion.languages') as $lang=>$lang_name)
    <a href="{{panel()->route('lang', $lang)}}" class="dropdown-item language py-2">
        <img alt="lang-flag" src="{{panel()->asset('/images/flags/'.$lang.'.svg')}}" class="me-2 rounded"
             height="18">
        <span class="align-middle">{{$lang_name}}
            @if(panel()->getCurrentLanguage() == $lang)
                <i class="ri-check-line float-end"></i>
            @endif
        </span>
    </a>
@endforeach
</div>
</div>
