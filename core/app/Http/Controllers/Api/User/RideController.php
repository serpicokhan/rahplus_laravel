<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Ride;
use App\Models\Zone;
use App\Models\Coupon;
use App\Models\Driver;
use App\Models\Service;
use App\Models\SosAlert;
use App\Constants\Status;
use App\Events\Ride as EventsRide;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Bid;
use App\Models\Deposit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class RideController extends Controller
{
    public function findFareAndDistance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id'            => 'required|integer',
            'pickup_latitude'       => 'required|numeric',
            'pickup_longitude'      => 'required|numeric',
            'destination_latitude'  => 'required|numeric',
            'destination_longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", 'error', $validator->errors()->all());
        }

        $service = Service::active()->find($request->service_id);

        if (!$service) {
            $notify[] = 'This service is currently unavailable';
            return apiResponse("not_found", 'error', $notify);
        }

        $zoneData = $this->getZone($request);

        if (@$zoneData['status'] == 'error') {
            $notify[] = $zoneData['message'];
            return apiResponse('not_found', 'error', $notify);
        }

        $googleMapData = $this->getGoogleMapData($request);

        if (@$googleMapData['status'] == 'error') {
            $notify[] = $googleMapData['message'];
            return apiResponse('api_error', 'error', $notify);
        }

        $pickUpZone      = $zoneData['pickup_zone'];
        $destinationZone = $zoneData['destination_zone'];
        $distance        = $googleMapData['distance'];
        $data            = $googleMapData;

        if ($pickUpZone->id == $destinationZone->id) {
            $data['min_amount']       = getAmount($service->city_min_fare * $distance);
            $data['max_amount']       = getAmount($service->city_max_fare * $distance);
            $data['recommend_amount'] = getAmount($service->city_recommend_fare * $distance);
            $data['ride_type']        = Status::CITY_RIDE;
        } else {
            $data['min_amount']       = getAmount($service->intercity_min_fare * $distance);
            $data['max_amount']       = getAmount($service->intercity_max_fare * $distance);
            $data['recommend_amount'] = getAmount($service->intercity_recommend_fare * $distance);
            $data['ride_type']        = Status::INTER_CITY_RIDE;
        }

        return apiResponse("ride_data", 'success', data: $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id'            => 'required|integer',
            'pickup_latitude'       => 'required|numeric',
            'pickup_longitude'      => 'required|numeric',
            'destination_latitude'  => 'required|numeric',
            'destination_longitude' => 'required|numeric',
            'note'                  => 'nullable',
            'number_of_passenger'   => 'required|integer',
            'offer_amount'          => 'required|numeric',
            'payment_type'          => ['required', Rule::in(Status::PAYMENT_TYPE_GATEWAY, Status::PAYMENT_TYPE_CASH)],
            'gateway_currency_id'   => $request->payment_type == Status::PAYMENT_TYPE_GATEWAY ? 'required|exists:gateway_currencies,id' : 'nullable',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", 'error', $validator->errors()->all());
        }

        $existsRide = Ride::where('user_id', auth()->id())->whereIn('status', [Status::RIDE_ACTIVE, Status::RIDE_ACTIVE])->exists();

        if ($existsRide) {
            $notify[] = 'You can create a ride, after finish an ongoing ride.';
            return apiResponse("not_found", 'error', $notify);
        }

        $service = Service::active()->find($request->service_id);

        if (!$service) {
            $notify[] = 'This service is currently unavailable';
            return apiResponse("not_found", 'error', $notify);
        }

        $zoneData = $this->getZone($request);

        if (@$zoneData['status'] == 'error') {
            $notify[] = $zoneData['message'];
            return apiResponse('not_found', 'error', $notify);
        }

        $googleMapData = $this->getGoogleMapData($request);

        if (@$googleMapData['status'] == 'error') {
            $notify[] = $googleMapData['message'];
            return apiResponse('api_error', 'error', $notify);
        }

        $data            = $googleMapData;
        $pickUpZone      = $zoneData['pickup_zone'];
        $destinationZone = $zoneData['destination_zone'];
        $distance        = $googleMapData['distance'];
        $user            = auth()->user();

        if ($pickUpZone->country !=  $destinationZone->country) {  // can not create ride between two country
            $notify[] = "The pickup zone and destination zone must be within the same country.";
            return apiResponse('zone_error', 'error', $notify);
        }

        if ($pickUpZone->id == $destinationZone->id) {  // city ride
            $data['min_amount']            = getAmount($service->city_min_fare * $distance);
            $data['max_amount']            = getAmount($service->city_max_fare * $distance);
            $data['recommend_amount']      = getAmount($service->city_recommend_fare * $distance);
            $data['ride_type']             = Status::CITY_RIDE;
            $data['commission_percentage'] = getAmount($service->city_fare_commission);
        } else {
            $data['min_amount']            = getAmount($service->intercity_min_fare * $distance);
            $data['max_amount']            = getAmount($service->intercity_max_fare * $distance);
            $data['recommend_amount']      = getAmount($service->intercity_recommend_fare * $distance);
            $data['ride_type']             = Status::INTER_CITY_RIDE;
            $data['commission_percentage'] = getAmount($service->intercity_fare_commission);
        }

        if ($distance < gs('min_distance')) {
            $notify[] = 'Minimum distance must be ' . getAmount(gs('min_distance')) . ' km';
            return apiResponse('limit_error', 'error', $notify);
        }

        if ($request->offer_amount < $data['min_amount'] || $request->offer_amount > $data['max_amount']) {
            $notify[] = 'The offer amount must be a minimum of ' . showAmount($data['min_amount']) . ' to a maximum of ' . showAmount($data['max_amount']);
            return apiResponse('limit_error', 'error', $notify);
        }

        $ride                        = new Ride();
        $ride->uid                   = getTrx(10);
        $ride->user_id               = $user->id;
        $ride->service_id            = $request->service_id;
        $ride->pickup_location       = @$data['origin_address'];
        $ride->pickup_latitude       = $request->pickup_latitude;
        $ride->pickup_longitude      = $request->pickup_longitude;
        $ride->destination           = @$data['destination_address'];
        $ride->destination_latitude  = $request->destination_latitude;
        $ride->destination_longitude = $request->destination_longitude;
        $ride->ride_type             = $data['ride_type'];
        $ride->note                  = $request->note;
        $ride->number_of_passenger   = $request->number_of_passenger;
        $ride->distance              = $distance;
        $ride->duration              = $data['duration'];
        $ride->pickup_zone_id        = $pickUpZone->id;
        $ride->destination_zone_id   = $destinationZone->id;
        $ride->recommend_amount      = $data['recommend_amount'];
        $ride->min_amount            = $data['min_amount'];
        $ride->max_amount            = $data['max_amount'];
        $ride->amount                = $request->offer_amount;
        $ride->payment_type          = $request->payment_type;
        $ride->commission_percentage = $data['commission_percentage'];
        $ride->gateway_currency_id   = $request->payment_type == Status::PAYMENT_TYPE_GATEWAY ? $request->gateway_currency_id : 0;
        $ride->save();

        //sent pusher event berfore find the dirver and sent notification to the driver
        // it is help to optimize loading response time
        event(new EventsRide("rider-user-$ride->user_id", "NEW_RIDE_CREATED", [
            'ride' => $ride,
        ]));

        $drivers = Driver::active()
            ->where('online_status', Status::YES)
            ->where('zone_id', $ride->pickup_zone_id)
            ->where("service_id", $ride->service_id)
            ->where('dv', Status::VERIFIED)
            ->where('vv', Status::VERIFIED)
            ->notRunning()
            ->get();

        $shortCode = [
            'ride_id'         => $ride->uid,
            'service'         => $ride->service->name,
            'pickup_location' => $ride->pickup_location,
            'destination'     => $ride->destination,
            'duration'        => $ride->duration,
            'distance'        => $ride->distance
        ];

        $ride->load('user', 'service', 'driver', 'driver.vehicle', 'driver.vehicle.model', 'driver.vehicle.color', 'driver.vehicle.year');

        $driverImagePath = getFilePath('driver');
        $userImagePath   = getFilePath('user');

        foreach ($drivers as $driver) {
            notify($driver, 'NEW_RIDE', $shortCode);
            event(new EventsRide("rider-driver-$driver->id", "NEW_RIDE", [
                'ride'              => $ride,
                'driver_image_path' => $driverImagePath,
                'user_image_path'   => $userImagePath,
            ]));
        }
        $notify[] = 'Ride created successfully';
        return apiResponse('ride_create_success', 'success', $notify, [
            'ride' => $ride
        ]);
    }

    public function details($id)
    {
        $ride = Ride::with(['bids', 'userReview', 'driver', 'service', 'driver.vehicle', 'driver.vehicle.model', 'driver.vehicle.color', 'driver.vehicle.year'])
            ->where('user_id', auth()->id())
            ->find($id);

        if (!$ride) {
            $notify[] = 'Invalid ride';
            return apiResponse('not_found', 'error', $notify);
        }

        $driverRideCount = Ride::where('driver_id', $ride->driver_id)->where('id', '!=', $ride->id)->where('status', Status::RIDE_COMPLETED)->count();
        $notify[]        = 'Ride Details';

        return apiResponse('ride_details', 'success', $notify, [
            'ride'               => $ride,
            'service_image_path' => getFilePath('service'),
            'brand_image_path'   => getFilePath('brand'),
            'user_image_path'    => getFilePath('user'),
            'driver_image_path'  => getFilePath('driver'),
            'driver_total_ride'  => $driverRideCount
        ]);
    }

    public function cancel(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'cancel_reason' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", 'error', $validator->errors()->all());
        }

        $ride = Ride::whereIn('status', [Status::RIDE_PENDING, Status::RIDE_ACTIVE])->where('user_id', auth()->id())->find($id);

        if (!$ride) {
            $notify[] = 'Ride not found';
            return apiResponse("not_found", 'error', $notify);
        }

        $cancelRideCount = Ride::where('user_id', auth()->id())
            ->where('canceled_user_type', Status::USER)
            ->count();

        if ($cancelRideCount >= gs('user_cancellation_limit')) {
            $notify[] = 'You have already exceeded the cancellation limit for this month';
            return apiResponse("limit_exceeded", 'error', $notify);
        }

        $ride->cancel_reason      = $request->cancel_reason;
        $ride->canceled_user_type = Status::USER;
        $ride->status             = Status::RIDE_CANCELED;
        $ride->cancelled_at       = now();
        $ride->save();

        if ($ride->status == Status::RIDE_ACTIVE) {
            notify($ride->driver, 'CANCEL_RIDE', [
                'ride_id'         => $ride->uid,
                'reason'          => $ride->cancel_reason,
                'amount'          => showAmount($ride->amount, currencyFormat: false),
                'service'         => $ride->service->name,
                'pickup_location' => $ride->pickup_location,
                'destination'     => $ride->destination,
                'duration'        => $ride->duration,
                'distance'        => $ride->distance,
            ]);
        }
        $notify[] = 'Ride canceled successfully';
        return apiResponse("canceled_ride", 'success', $notify);
    }

    public function sos(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'message'   => 'nullable',
        ]);

        if ($validator->fails()) {
            return apiResponse('validation_error', 'error', $validator->errors()->all());
        }

        $ride = Ride::running()->where('user_id', auth()->id())->find($id);

        if (!$ride) {
            $notify[] = 'The ride is not found';
            return apiResponse('invalid_ride', 'error', $notify);
        }

        $sosAlert            = new SosAlert();
        $sosAlert->ride_id   = $id;
        $sosAlert->latitude  = $request->latitude;
        $sosAlert->longitude = $request->longitude;
        $sosAlert->message   = $request->message;
        $sosAlert->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $ride->user->id;
        $adminNotification->title     = 'A new SOS Alert has been created, please take action';
        $adminNotification->click_url = urlPath('admin.rides.detail', $ride->id);
        $adminNotification->save();

        $notify[] = 'SOS request successfully';
        return apiResponse("sos_request", "success", $notify);
    }


    public function list()
    {
        $rides = Ride::with(['driver', 'user', 'service', 'driver.vehicle', 'driver.vehicle.model', 'driver.vehicle.color', 'driver.vehicle.year'])
            ->filter(['ride_type', 'status'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        $notify[]      = "Get the ride list";
        $data['rides'] = $rides;
        return apiResponse("ride_list", 'success', $notify, $data);
    }

    private function getZone($request)
    {
        $zones           = Zone::active()->get();
        $pickupAddress   = ['lat' => $request->pickup_latitude, 'long' => $request->pickup_longitude];
        $pickupZone      = null;
        $destinationZone = null;

        foreach ($zones as $zone) {
            $pickupZone = insideZone($pickupAddress, $zone);
            if ($pickupZone) {
                $pickupZone = $zone;
                break;
            }
        }

        if (!$pickupZone) {
            return [
                'status'  => 'error',
                'message' => 'The pickup location is not inside any of our zones'
            ];
        }

        $destinationAddress = ['lat' => $request->destination_latitude, 'long' => $request->destination_longitude];

        foreach ($zones as $zone) {
            $destinationZone = insideZone($destinationAddress, $zone);

            if ($destinationZone) {
                $destinationZone = $zone;
                break;
            }
        }

        if (!$destinationZone) {
            return [
                'status'  => 'error',
                'message' => 'The destination location is not inside any of our zones'
            ];
        }

        return [
            'pickup_zone'      => $pickupZone,
            'destination_zone' => $destinationZone,
            'status'           => 'success'
        ];
    }
    private function getGoogleMapData($request)
    {
        $apiKey        = gs('google_maps_api');
        $url           = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$request->pickup_latitude},{$request->pickup_longitude}&destinations={$request->destination_latitude},{$request->destination_longitude}&units=driving&key={$apiKey}";
        $response      = file_get_contents($url);
        $googleMapData = json_decode($response);

        if ($googleMapData->status != 'OK') {
            return [
                'status'  => 'error',
                'message' => 'Something went wrong!'
            ];
        }

        if ($googleMapData->rows[0]->elements[0]->status == 'ZERO_RESULTS') {
            return [
                'status'  => 'error',
                'message' => 'Direction not found'
            ];
        }

        $distance = $googleMapData->rows[0]->elements[0]->distance->value / 1000;
        $duration = $googleMapData->rows[0]->elements[0]->duration->text;

        return [
            'distance'            => $distance,
            'duration'            => $duration,
            'origin_address'      => $googleMapData->origin_addresses[0],
            'destination_address' => $googleMapData->destination_addresses[0],
        ];
    }

    public function bids($id)
    {
        $ride = Ride::where('user_id', auth()->id())->find($id);

        if (!$ride) {
            $notify[] = 'The ride is not found';
            return apiResponse('not_found', 'error', $notify);
        }

        $bids     = Bid::with(['driver', 'driver.service', 'driver.vehicle', 'driver.vehicle.model', 'driver.vehicle.color', 'driver.vehicle.year'])->where('ride_id', $ride->id)->whereIn('status', [Status::BID_PENDING, Status::BID_ACCEPTED])->get();
        $notify[] = 'All Bid';

        return apiResponse("bids", "success", $notify, [
            'bids'              => $bids,
            'ride'              => $ride,
            'driver_image_path' => getFilePath('driver'),
            'user_image_path'   => getFilePath('user'),
        ]);
    }

    public function accept($bidId)
    {
        $bid = Bid::pending()->with('ride')->whereHas('ride', function ($q) {
            return $q->pending()->where('user_id', auth()->id());
        })->find($bidId);

        if (!$bid) {
            $notify[] = 'Invalid bid';
            return apiResponse('not_found', 'error', $notify);
        }

        $bid->status      = Status::BID_ACCEPTED;
        $bid->accepted_at = now();
        $bid->save();

        //all the bid rejected after the one accept this bid
        Bid::where('id', '!=', $bid->id)->where('ride_id', $bid->ride_id)->update(['status' => Status::BID_REJECTED]);

        $ride            = $bid->ride;
        $ride->status    = Status::RIDE_ACTIVE;
        $ride->driver_id = $bid->driver_id;
        $ride->otp       = getNumber(6);
        $ride->amount    = $bid->bid_amount;
        $ride->save();

        $ride->load('driver', 'driver.vehicle', 'driver.vehicle.model', 'driver.vehicle.color', 'driver.vehicle.year', 'service', 'user');
        $driverRideCount = Ride::where('driver_id', $ride->driver_id)->where('id', '!=', $ride->id)->where('status', Status::RIDE_COMPLETED)->count();

        event(new EventsRide("rider-driver-$ride->driver_id", "BID_ACCEPT", [
            'ride'              => $ride,
            'driver_total_ride' => $driverRideCount
        ]));

        notify($ride->driver, 'ACCEPT_RIDE', [
            'ride_id'         => $ride->uid,
            'amount'          => showAmount($ride->amount),
            'rider'           => $ride->user->username,
            'service'         => $ride->service->name,
            'pickup_location' => $ride->pickup_location,
            'destination'     => $ride->destination,
            'duration'        => $ride->duration,
            'distance'        => $ride->distance
        ]);

        $notify[] = 'Bid accepted successfully';
        return apiResponse('accepted', 'success', $notify, [
            'ride' => $ride
        ]);
    }

    public function reject($id)
    {
        $bid = Bid::pending()->with('ride', 'driver')->find($id);

        if (!$bid) {
            $notify[] = 'Invalid bid';
            return apiResponse('not_found', 'error', $notify);
        }

        $ride = $bid->ride;
        if ($ride->user_id != auth()->id()) {
            $notify[] = 'This ride is not for this rider';
            return apiResponse('unauthenticated', 'error', $notify);
        }

        $bid->status = Status::BID_REJECTED;
        $bid->save();

        event(new EventsRide("rider-driver-$bid->driver_id", 'BID_REJECT', [
            'ride' => $ride
        ]));

        notify($ride->driver, 'BID_REJECT', [
            'ride_id'         => $ride->uid,
            'amount'          => showAmount($bid->bid_amount),
            'service'         => $ride->service->name,
            'pickup_location' => $ride->pickup_location,
            'destination'     => $ride->destination,
            'duration'        => $ride->duration,
            'distance'        => $ride->distance
        ]);

        $notify[] = 'Bid rejected successfully';
        return apiResponse('rejected_bid', 'success', $notify);
    }

    public function payment($id)
    {
        $ride = Ride::where('user_id', auth()->id())->find($id);

        if (!$ride) {
            $notify[] = 'The ride is not found';
            return apiResponse('not_found', 'error', $notify);
        }

        $ride->load('driver', 'driver.vehicle', 'driver.vehicle.model', 'driver.vehicle.color', 'driver.vehicle.year', 'service', 'user', 'coupon');

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->active()->automatic();
        })->with('method')->orderby('method_code')->get();

        $notify[] = "Ride Payments";
        return apiResponse('payment', 'success', $notify, [
            'gateways'          => $gatewayCurrency,
            'image_path'        => getFilePath('gateway'),
            'ride'              => $ride,
            'coupons'           => Coupon::orderBy('id', 'desc')->active()->get(),
            'driver_image_path' => getFilePath('driver'),
        ]);
    }

    public function paymentSave(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_type' => ['required', Rule::in(Status::PAYMENT_TYPE_GATEWAY, Status::PAYMENT_TYPE_CASH)],
            'method_code'  => 'required_if:payment_type,1',
            'currency'     => 'required_if:payment_type,1',
            'tips_amount'  => 'required|numeric|gte:0'
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", 'error', $validator->errors()->all());
        }

        $ride  = Ride::where('user_id', auth()->id())->find($id);

        if (!$ride) {
            $notify[] = 'The ride is not found';
            return apiResponse('not_found', 'error', $notify);
        }

        if ($ride->status == Status::RIDE_COMPLETED) {
            $notify[] = 'The ride is already completed';
            return apiResponse('not_found', 'error', $notify);
        }

        $ride->tips_amount = $request->tips_amount;
        $ride->save();

        if ($request->payment_type == Status::PAYMENT_TYPE_GATEWAY) {
            return $this->paymentViaGateway($request, $ride);
        } else {

            $ride->payment_status = Status::WAITING_FOR_CASH_PAYMENT;
            $ride->save();

            $ride->load('driver.vehicle', 'driver.vehicle.model', 'driver.vehicle.color', 'driver.vehicle.year', 'user', 'service');

            event(new EventsRide("rider-driver-$ride->driver_id", 'CASH_PAYMENT_REQUEST', [
                'ride' => $ride
            ]));

            event(new EventsRide("rider-user-$ride->user_id", 'CASH_PAYMENT_REQUEST', [
                'ride' => $ride
            ]));

            $notify[] = "Please give the driver " . showAmount($ride->amount) . " in cash.";
            return apiResponse('cash_payment', 'success', $notify, [
                'ride' => $ride
            ]);
        }
    }

    private function paymentViaGateway($request, $ride)
    {
        $amount = $ride->amount - $ride->discount_amount + $ride->tips_amount;

        $gateway = GatewayCurrency::whereHas('method', function ($gateway) {
            $gateway->active()->automatic();
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();

        if (!$gateway) {
            $notify[] = "Invalid gateway selected";
            return apiResponse('not_found', 'error', $notify);
        }

        if ($gateway->min_amount > $amount) {
            $notify[] = 'Minimum limit for this gateway is ' . showAmount($gateway->min_amount);
            return apiResponse('limit_exists', 'error', $notify);
        }
        if ($gateway->max_amount < $amount) {
            $notify[] = 'Maximum limit for this gateway is ' . showAmount($gateway->max_amount);
            return apiResponse('limit_exists', 'error', $notify);
        }

        $charge      = 0;
        $payable     = $amount + $charge;
        $finalAmount = $payable * $gateway->rate;
        $user        = auth()->user();

        $data                  = new Deposit();
        $data->from_api        = 1;
        $data->user_id         = $user->id;
        $data->method_code     = $gateway->method_code;
        $data->method_currency = strtoupper($gateway->currency);
        $data->amount          = $amount;
        $data->charge          = $charge;
        $data->rate            = $gateway->rate;
        $data->final_amount    = $finalAmount;
        $data->ride_id         = $ride->id;
        $data->btc_amount      = 0;
        $data->btc_wallet      = "";
        $data->success_url     = urlPath('user.deposit.history');
        $data->failed_url      = urlPath('user.deposit.history');
        $data->trx             = getTrx();
        $data->save();

        $notify[] = "Online Payment";

        return apiResponse("gateway_payment", "success", $notify, [
            'deposit'      => $data,
            'redirect_url' => route('deposit.app.confirm', encrypt($data->id))
        ]);
    }
    public function receipt($id)
    {
        $ride     = Ride::with(['user', 'driver'])->where('user_id', auth()->id())->find($id);

        if (!$ride) {
            $notify[] = "The ride is not available";
            return apiResponse('not_exists', 'error', $notify);
        }

        if ($ride->status != Status::RIDE_COMPLETED) {
            $notify[] = "The ride received is not available at the moment";
            return apiResponse('not_exists', 'error', $notify);
        }

        $type = "user";
        $pdf      = Pdf::loadView('admin.rides.pdf', compact('ride', 'type'));
        $fileName = 'ride.pdf';

        return $pdf->stream($fileName);
    }
}
