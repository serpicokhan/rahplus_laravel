<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.rider.all')" variant="primary" title="Total Drivers" :value="$widget['all']"
            icon="las la-car" :currency=false />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four url="{{ route('admin.rider.all') }}?date={{ now()->toDateString() }}" variant="danger"
            title="Drivers Joined Today" :value="$widget['today']" icon="las la-clock" :currency=false />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four
            url="{{ route('admin.rider.all') }}?date={{ now()->subDays(7)->toDateString() }}to{{ now()->toDateString() }}"
            variant="success" title="Drivers Joined Last Week" :value="$widget['week']" icon="las la-calendar"
            :currency=false />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four
            url="{{ route('admin.rider.all') }}?date={{ now()->subDays(30)->toDateString() }}to{{ now()->toDateString() }}"
            variant="primary" title="Drivers Joined Last Month" :value="$widget['month']" icon="las la-calendar-plus"
            :currency=false />
    </div>
</div>
