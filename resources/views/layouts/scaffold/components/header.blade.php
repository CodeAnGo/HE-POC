<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
    <div class="kt-header__top">
        <div class="kt-container  kt-container--fluid ">

            <!-- begin:: Brand -->
            <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
                <div class="kt-header__brand-logo">
                    <a href="/dashboard">
                        <img alt="Logo" width="200px" src="{{ asset('media/logos/cloudburst.png') }}" class="kt-header__brand-logo-default" />
                    </a>
                </div>
            </div>

            <!-- end:: Brand -->

            <!-- begin:: Header Topbar -->
            <div class="kt-header__topbar">

                <!--begin: Search -->
                <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown kt-hidden-desktop" id="kt_quick_search_toggle">
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                        <div class="kt-quick-search kt-quick-search--inline" id="kt_quick_search_inline">
                            <form method="get" class="kt-quick-search__form">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                                    <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                                    <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
                                </div>
                            </form>
                            <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                            </div>
                        </div>
                    </div>
                </div>

                <!--end: Search -->


                <!--begin: User bar -->
                <div class="kt-header__topbar-item kt-header__topbar-item--user">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px" aria-expanded="false">
                        <span class="kt-header__topbar-welcome">Hi,</span>
                        <span class="kt-header__topbar-username">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->getProfile->profile_picture == null)
                            <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ Auth::user()->getInitials() }}</span>
                        @else
                            <img alt="pfp" src="{{ Auth::user()->getProfilePicture() }}" />
                        @endif
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                        <!--begin: Head -->
                        <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url({{ asset('media/misc/bg-1.jpg') }})">
                            <div class="kt-user-card__avatar">

                                @if(Auth::user()->getProfile->profile_picture == null)
                                    <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ Auth::user()->getInitials() }}</span>
                                @else
                                    <img alt="pfp" src="{{ Auth::user()->getProfilePicture() }}" />
                                @endif

                                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                            </div>
                            <div class="kt-user-card__name">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="kt-user-card__badge">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-label-warning btn-sm btn-bold">Sign Out</button>
                                </form>
                            </div>
                        </div>

                        <!--end: Head -->


                        <!--end: Navigation -->
                    </div>
                </div>

                <!--end: User bar -->
            </div>

            <!-- end:: Header Topbar -->
        </div>
    </div>
    <div class="kt-header__bottom">
        <div class="kt-container  kt-container--fluid ">

            <!-- begin: Header Menu -->
            <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
            <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                    <ul class="kt-menu__nav ">
                        <li class="kt-menu__item  kt-menu__item--open @if(Request::is('dashboard')) kt-menu__item--here @endif kt-menu__item--rel kt-menu__item--open"><a href="{{ route('dashboard.index') }}" class="kt-menu__link"><span class="kt-menu__link-text">Dashboard</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a></li>
                    </ul>
                </div>
                <div class="kt-header-toolbar">
                    <div class="kt-quick-search" id="kt_quick_search_default">
                        <form method="get" class="kt-quick-search__form">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                                <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                                <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
                            </div>
                        </form>
                        <div id="kt_quick_search_toggle" data-toggle="dropdown" data-offset="0px,10px"></div>
                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                            <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end: Header Menu -->
        </div>
    </div>
</div>
