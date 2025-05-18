<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabcart</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
            font-family: "Albert Sans", sans-serif;
        }

        .container {
            margin-right: auto;
            margin-left: auto;
        }

        .logo {
            width: 50%;
        }

        .fw-bold {
            font-weight: 700;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .fw-medium {
            font-weight: 500;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .d-block {
            display: block;
        }

        .mt-0 {
            margin-top: 0;
        }

        .ms-auto {
            margin-left: auto;
        }

        .me-auto {
            margin-right: auto;
        }

        .mx-auto {
            margin: 0 auto;
        }

        .py-15 {
            padding: 0px 15px;
        }

        .m-0 {
            margin: 0;
        }

        .mt-3 {
            margin-top: 16px;
        }

        .mt-4 {
            margin-top: 24px;
        }

        .mt-5 {
            margin-top: 32px;
        }

        .mb-3 {
            margin-bottom: 16px;
        }

        .mb-4 {
            margin-bottom: 24px;
        }

        .mb-5 {
            margin-bottom: 32px;
        }

        .mb-6 {
            margin-bottom: 50px;
        }

        .mt-6 {
            margin-top: 50px;
        }

        .ps-3 {
            padding-left: 16px;
        }

        .pe-3 {
            padding-right: 16px;
        }

        .logo img {
            max-width: 100%;
        }

        table {
            margin: 0;
            border: 0;
            width: 100%;
            border-collapse: collapse;
        }

        .text-muted {
            color: rgb(var(--text-color));
        }

        .text-white {
            color: #fff;
        }

        .company-details {
            text-align: right;
        }

        .heading {
            font-size: 20px;
            margin-bottom: 08px;
        }

        .sub-heading {
            color: #262626;
            margin-bottom: 05px;
        }

        table {
            background-color: transparent;
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr {
            border: 1px solid #111;
            background-color: #f2f2f2;
        }

        table td {
            vertical-align: middle !important;
            text-align: center;
        }

        table th,
        table td {
            padding-top: 08px;
            padding-bottom: 08px;
        }

        .table-bordered {
            box-shadow: 0px 0px 5px 0.5px gray;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-right {
            text-align: end;
        }

        .w-20 {
            width: 20%;
        }

        .list--row {
            overflow: auto
        }

        .list--row::after {
            content: '';
            display: block;
            clear: both;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .d-block {
            display: block;
        }

        .d-inline-block {
            display: inline-block;
        }

        .badge {
            padding: 5px 10px;
            text-align: center;
        }

        .badge-gray {
            background-color: #E0E7F4;
        }

        .body-section {
            padding: 0px 60px;
        }

        .logo-text {
            font-size: 30px;
            text-align: left;
        }

        .brand-section,
        .main-wrapper__body {
            padding: 0px 50px
        }

        .brand-section {
            padding-top: 30px;
        }

        .brand-section table tr td {
            vertical-align: middle;
        }

        .hero-banner {
            margin-top: 50px;
            position: relative;

        }


        .hero-banner__title {
            margin-bottom: 15px;
        }


        .hero-banner_thumb {
            position: absolute;
            top: -40px;
            right: 50px;
            max-width: 150px;
        }

        .hero-banner-shape {
            position: absolute;
            width: 100%;
            height: auto;
            z-index: -1;
            top: 0px;
            left: 0px;
            height: auto;
            background-size: cover;
            mask-image: url('shape.svg');

        }

        .hero-banner__title {
            font-size: 50px;
            line-height: 1.2;
        }

        .hero-banner__desc {
            margin-top: 5px;
        }

        .text-left {
            text-align: left;
        }

        .ride-price-content .total {
            font-size: 40px;
        }

        .ride-price-info .title {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .ride-price-info .desc {
            font-size: 20px;
            font-weight: 500;
        }

        .ride-price-content {
            padding-bottom: 5px;
            margin-bottom: 30px;
            border-bottom: 1px solid #13e2f7;
            margin-top: 20px;
        }

        .trip-summary {
            padding: 0px 15px;
        }

        .trip-summary h4 {
            font-size: 16px;
            font-weight: 400;
            color: #333;
            margin-bottom: 5px;
        }

        .trip-summary p {
            font-size: 12px;
            color: #666;
        }

        .trip-timeline {
            margin-top: 15px;
            border-left: 2px solid black;
            padding-left: 7px;
        }

        .trip-stop {
            position: relative;
            margin-bottom: 30px;
            padding-left: 15px;
        }

        .trip-stop::before {
            content: "";
            position: absolute;
            width: 15px;
            height: 15px;
            left: -15px;
            font-size: 14px;
            background-color: black;

        }

        .trip-start::before {
            top: 0px;
        }

        .trip-end::before {
            position: absolute;
            top: 28px !important;
        }

        .trip-stop strong {
            display: block;
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .trip-stop span {
            font-size: 14px;
            color: #666;
        }

        .summary-container {
            padding: 0px 15px;
        }

        .payment-method {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .payment-method .badge {
            display: inline-block;
            padding: 5px 10px;
            background: #ddd;
            color: #555;
            border-radius: 5px;
            font-size: 12px;
            margin-top: 8px;
        }

        .total-row {
            border-top: 2px solid #2d93ba;
            padding-top: 20px;
            margin-top: 10px;
        }

        .total-box {
            background-color: #2d93ba;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            font-size: 18px;
        }

        .total-box,
        .badge-gray,
        .trip-stop:before {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        @media print {
            @page {
                margin: 0;
                /* Removes default browser margins */
            }

            body {
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-wrapper">
            <div class="brand-section header-image">
                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(asset('assets/images/pdf_shape.png'))) }}"
                    alt="img" class="hero-banner-shape">
                <table class="mb-4">
                    <tbody>
                        <tr>
                            <td>
                                <div class="logo">
                                    <h2 class="logo-text">{{ gs('site_name') }}</h2>
                                </div>
                            </td>
                            <td>
                                <div class="text-end">

                                    <strong class="total-amount">{{ showDateTime($ride->created_at) }}</strong>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="hero-banner">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 70%;">
                                    @if ($type == 'user')
                                        <div class="text-left pe-3">
                                            <h1 class="hero-banner__title">@lang('Thanks for riding'), <br>
                                                {{ @$ride->user->fullname }}</h1>
                                            <p class="hero-banner__desc">@lang("We're glad to have you as an") <br>
                                                {{ __(gs('site_name')) }}
                                                @lang('Member')</p>
                                        </div>
                                    @else
                                        <div class="text-left pe-3">
                                            <h1 class="hero-banner__title">@lang('Thanks for ride'), <br>
                                                {{ @$ride->driver->fullname }}</h1>
                                            <p class="hero-banner__desc">@lang("We're glad to have you as an") <br>
                                                {{ __(gs('site_name')) }}
                                                @lang('Member')</p>
                                        </div>
                                    @endif
                                </td>
                                <td style="width: 30%;">
                                    <div class="text-end ps-3">
                                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(imageGet('service', @$ride->service->image))) }}"
                                            class="hero-banner_thumb" alt="">

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="main-wrapper__body">
                <div class="ride-price-content">
                    <table class="table mt-5">
                        <tbody>
                            <tr>
                                <td style="width: 50%;">
                                    <div class="text-left pe-3">
                                        <h2 class="total">@lang('Total')</h2>
                                    </div>
                                </td>
                                <td style="width: 50%;">
                                    <div class="text-end ps-3">
                                        <div class="ride-price-info">
                                            <h3 class="title">{{ showAmount($ride->amount + $ride->tips_amount) }}</h3>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="trip-summary">
                    <h4>@lang('Distance'): {{ getAmount($ride->distance) }} @lang('kilometers') |
                        @lang('Duration'):
                        {{ $ride->duration }}
                    </h4>
                    <div class="trip-timeline">
                        <div class="trip-stop trip-start">
                            <strong>{{ showDateTime($ride->start_time) }}</strong>
                            <span>{{ $ride->pickup_location }}</span>
                        </div>
                        <div class="trip-stop trip-end">
                            <strong>{{ showDateTime($ride->end_time) }}</strong>
                            <span>{{ $ride->destination }}</span>
                        </div>
                    </div>
                </div>

                <div class="summary-container list--row mt-6">
                    <div class="payment-section float-left" style="width: 50%;">
                        <p class="payment-method mb-4">
                            @lang('Payment Method')
                        </p>
                        <span class="badge badge-gray">
                            @if ($ride->payment_type == Status::PAYMENT_TYPE_CASH)
                                @lang('Cash')
                            @else
                                {{ __(@$ride->payment->gateway->name) }}
                            @endif
                        </span>
                    </div>

                    <div class="table-container  float-right" style="width: 40%;">
                        <table>
                            <tr>
                                <td class="text-start"><strong>@lang('Ride Fare')</strong></td>
                                <td><strong>{{ showAmount($ride->amount) }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-start"><strong>@lang('Tips Amount')</strong></td>
                                <td><strong>{{ showAmount($ride->tips_amount) }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="total-row">
                                        <div class="total-box  text-uppercase">
                                            @lang('Total') {{ showAmount($ride->amount + $ride->tips_amount) }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
