@props(['widget'])
<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.two :url="route('admin.rider.all')" variant="primary" title="Total Rider" :value="$widget['total_users']"
            icon="las la-users" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.two :url="route('admin.rider.active')" variant="success" title="Active Rider" :value="$widget['active_users']"
            icon="las la-user-check" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.two :url="route('admin.rider.email.unverified')" variant="warning" title="Email Unverified Rider" :value="$widget['email_unverified_users']"
            icon="lar la-envelope" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.two :url="route('admin.rider.mobile.unverified')" variant="danger" title="Mobile Unverified Rider" :value="$widget['mobile_unverified_users']"
            icon="las la-comment-slash" />
    </div>
</div>
