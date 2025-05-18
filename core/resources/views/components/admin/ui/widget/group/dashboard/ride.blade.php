@props(['widget'])
<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.rides.running')" variant="primary" title="Running Ride" :value="$widget['running_ride']"
            icon="las la-car" :currency="false" />
    </div>

    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.rides.completed')" variant="success" title="Completed Ride" :value="$widget['completed_ride']"
            icon="las la-route" :currency="false" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.rides.canceled')" variant="danger" title="Canceled Ride" :value="$widget['canceled_ride']"
            icon="las la-times-circle" :currency="false" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.rides.all')" variant="info" title="Total Ride" :value="$widget['total_ride']"
            icon="las la-list" :currency="false" />
    </div>
</div>
