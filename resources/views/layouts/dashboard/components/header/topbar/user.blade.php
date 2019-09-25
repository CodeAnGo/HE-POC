<div class="kt-header__topbar-item kt-header__topbar-item--user">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
        <div class="kt-header__topbar-user">
            <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
            <span class="kt-header__topbar-username kt-hidden-mobile">{{ Auth::user()->name }}</span>
            @if(Auth::user()->getProfile->profile_picture == null)
                <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ Auth::user()->getInitials() }}</span>
            @else
                <img alt="pfp" src="{{ Auth::user()->getProfilePicture() }}" />
            @endif
        </div>
    </div>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

        <!--begin: Head -->
        @include('layouts.dashboard.components.header.topbar.user.head')
        <!--end: Head -->

        <!--begin: Navigation -->
        @include('layouts.dashboard.components.header.topbar.user.navigation')
        <!--end: Navigation -->
    </div>
</div>
