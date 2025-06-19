<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="#" class="logo logo-dark">
                        <span class="logo-sm">
                            <img
                                src="{{$getBrandSmallLogoDark() ?? ($getBrandSmallLogo() ??panel()->asset('images/logo-sm-dark.png'))}}"
                                alt="">
                        </span>
                        <span class="logo-lg">
                            <img
                                src="{{$getBrandLogoDark() ?? ($getBrandLogo() ?? panel()->asset('images/logo-dark.png'))}}"
                                alt="">
                        </span>
                    </a>

                    <a href="#" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{$getBrandSmallLogo() ?? panel()->asset('images/logo-sm-light.png')}}" alt="">
                        </span>
                        <span class="logo-lg">
                            <img src="{{$getBrandLogo() ?? panel()->asset('images/logo-light.png')}}" alt="">
                        </span>
                    </a>
                </div>
                <button type="button"
                        class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none"
                        id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                {!! render($getComponents('topleft_start')) !!}
                {!! render($getComponents('topleft')) !!}
                {!! render($getComponents('topleft_end')) !!}
            </div>

            <div class="d-flex align-items-center">
                {!! render(panel()->doFilters('nav_top_right', [])) !!}
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                            class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                            data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                            class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>
                {!! render($getComponents('topright_end')) !!}

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                 src="{{panel()->auth()->user()->avatar ?? panel()->asset('images/users/user-dummy-img.jpg')}}"
                                 alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    {{panel()->auth()->user()->name}}
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        {!! render($getComponents('user_menu')) !!}
                        <a class="dropdown-item" href="#" data-action="/admin/logout" data-method="post">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">{{__('merlion::base.logout')}}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
