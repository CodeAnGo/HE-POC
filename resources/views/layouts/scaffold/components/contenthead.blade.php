<div class="kt-subheader kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">@yield('title')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <span class="kt-subheader__desc">@yield('description')</span>
            @yield('toolbar_left')
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                @yield('toolbar_right')
            </div>
        </div>
    </div>
</div>
