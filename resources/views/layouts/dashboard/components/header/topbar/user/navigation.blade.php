<div class="kt-notification">
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <i class="flaticon2-calendar-3 kt-font-success"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold">
                My Profile
            </div>
            <div class="kt-notification__item-time">
                Account settings and more
            </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <i class="flaticon2-mail kt-font-warning"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold">
                My Messages
            </div>
            <div class="kt-notification__item-time">
                Inbox and tasks
            </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <i class="flaticon2-rocket-1 kt-font-danger"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold">
                My Activities
            </div>
            <div class="kt-notification__item-time">
                Logs and notifications
            </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <i class="flaticon2-hourglass kt-font-brand"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold">
                My Tasks
            </div>
            <div class="kt-notification__item-time">
                latest tasks and projects
            </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <i class="flaticon2-cardiogram kt-font-warning"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold">
                Billing
            </div>
            <div class="kt-notification__item-time">
                billing & statements <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 pending</span>
            </div>
        </div>
    </a>
    <div class="kt-notification__custom kt-space-between">
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</button>
        </form>
        <a href="demo1/custom/user/login-v2.html" target="_blank" class="btn btn-clean btn-sm btn-bold">Upgrade Plan</a>
    </div>
</div>
