@props(['widget'])
<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.driver.all')" variant="primary" title="Total Driver" :value="$widget['total_driver']"
            icon="las la-users" :currency="false" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.driver.active')" variant="success" title="Active Driver" :value="$widget['active_driver']"
            icon="las la-user-check" :currency="false" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.driver.unverified')" variant="warning" title="Document Unnerified Driver" :value="$widget['document_unverified_driver']"
            icon="la la-list" :currency="false" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.driver.vehicle.unverified')" variant="danger" title="Vehicle Unnerified Driver" :value="$widget['vehicle_unverified_driver']"
            icon="las la-car" :currency="false" />
    </div>
</div>
