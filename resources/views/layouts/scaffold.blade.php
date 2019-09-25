<!DOCTYPE html>
<html lang="en">
@include('layouts.dashboard.components.head')
<link href="{{ asset('css/demo2/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            @include('layouts.scaffold.components.header')
            <!-- end:: Header -->
            <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                    <!-- begin:: Content Head -->
                    @include('layouts.scaffold.components.contenthead')
                    <!-- end:: Content Head -->

                    <!-- begin:: Content -->
                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                        @yield('content')
                    </div>
                    <!-- end:: Content -->
                </div>
            </div>

            <!-- begin:: Footer -->
            <div class="kt-footer  kt-footer--extended  kt-grid__item" id="kt_footer">
                <div class="kt-footer__bottom">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-footer__wrapper">
                            <div class="kt-footer__logo">
                                <a href="/">
                                    <img alt="Logo" width="200px" style="padding: 0px;" src="{{ asset('media/logos/cloudburst.png') }}">
                                </a>
                                <div class="kt-footer__copyright">
                                    {{ \Carbon\Carbon::now()->year }}&nbsp;&copy;&nbsp;
                                    <a href="https://netcompany.com/" target="_blank">Netcompany UK</a>
                                </div>
                            </div>
                            <div class="kt-footer__menu">
                                Built by the Netcompany Scaffold Tool.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>
<!-- end::Global Config -->

</body>

<!-- end::Body -->
</html>
