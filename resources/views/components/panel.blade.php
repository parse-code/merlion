<x-merlion::layouts.app :$attributes>
    <div id="layout-wrapper">

        @include('merlion::components.layouts.header')

        @include('merlion::components.layouts.siderbar')

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">
                                    @if($backUrl = $getBackUrl())
                                        <a href="{{$backUrl}}" class="me-1">
                                            <i class="px-1 py-0 ri-arrow-left-line"></i>
                                        </a>
                                    @endif
                                    {{$getPageTitle()}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    {!! render(panel()->getContent()) !!}
                    @stack('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    @include('merlion::components.layouts.footer')
    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    @push('scripts')
        <script nonce="{{csp_nonce()}}" src="{{panel()->asset('js/app.js')}}"></script>
        <script nonce="{{csp_nonce()}}" src="{{panel()->asset('js/admin.js')}}"></script>
    @endpush
</x-merlion::layouts.app>
