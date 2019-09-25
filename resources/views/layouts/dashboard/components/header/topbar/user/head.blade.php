<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(media/misc/bg-1.jpg)">
    <div class="kt-user-card__avatar">
        @if(Auth::user()->getProfile->profile_picture == null)
            <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ Auth::user()->getInitials() }}</span>
        @else
            <img alt="pfp" src="{{ Auth::user()->getProfilePicture() }}" />
        @endif
    </div>
    <div class="kt-user-card__name">
        {{ Auth::user()->name }}
    </div>
    <div class="kt-user-card__badge">
        <span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span>
    </div>
</div>
