@props(['widget'])
<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.report.rider.payment')" variant="success" title="Total Payment" :value="$widget['total_payment']"
            icon="la la-money-bill-wave" />
    </div>

    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.report.driver.commission')" variant="primary" title="Total Commission" :value="$widget['total_commission']"
            icon="la la-percentage" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.report.rider.payment') . '?payment_type='.Status::PAYMENT_TYPE_CASH.''" variant="success" title="Total Cash Payment" :value="$widget['total_cash_payment']"
            icon="fa-solid fa-sack-dollar" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.four :url="route('admin.report.rider.payment') . '?payment_type='.Status::PAYMENT_TYPE_GATEWAY.''" variant="warning" title="Total Online Payment" :value="$widget['total_online_payment']"
            icon="lab la-cc-paypal" />
    </div>
</div>
