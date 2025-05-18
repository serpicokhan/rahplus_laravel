<?php

namespace App\Http\Controllers\Api\Driver;

use App\Models\Bid;
use App\Models\Ride;
use App\Constants\Status;
use App\Events\Ride as EventsRide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Support\Facades\Validator;

class BidController extends Controller
{
    public function create(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bid_amount' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $ride   = Ride::pending()->find($id);

        if (!$ride) {
            $notify[] = "Invalid ride";
            return apiResponse("invalid", "error", $notify);
        }

        $driver = Driver::where('online_status', Status::YES)
            ->where('zone_id', $ride->pickup_zone_id)
            ->where("service_id", $ride->service_id)
            ->where('dv', Status::VERIFIED)
            ->where('vv', Status::VERIFIED)
            ->notRunning()
            ->where('id', auth()->id())
            ->first();

        if (!$driver) {
            $notify[] = "You are not eligible to place a bid on this ride.";
            return apiResponse("not_eligible", "error", $notify);
        }

        if ($driver->balance < gs('negative_balance_driver')) {
            $notify[] = "You have reached the maximum allowable negative balance. Please deposit funds to continue.";
            return apiResponse("limit", "error", $notify);
        }

        if ($request->bid_amount < $ride->min_amount || $request->bid_amount > $ride->max_amount) {
            $notify[] = 'Bid amount must be a minimum ' .  showAmount($ride->min_amount) . ' to a maximum of ' . showAmount($ride->max_amount);
            return apiResponse("limit", "error", $notify);
        }

        $bidExists = Bid::where('ride_id', $id)->where('driver_id', $driver->id)->whereIn('status', [Status::BID_PENDING, Status::BID_ACCEPTED])->first();

        if ($bidExists) {
            $notify[] = 'You have already bid ' . showAmount($bidExists->bid_amount) . ' on this ride';
            return apiResponse("exists", "error", $notify);
        }

        $bid             = new Bid();
        $bid->ride_id    = $ride->id;
        $bid->driver_id  = $driver->id;
        $bid->bid_amount = $request->bid_amount;
        $bid->status     = Status::BID_PENDING;
        $bid->save();

        $bid->load('driver', 'driver.vehicle', 'driver.vehicle.model', 'driver.vehicle.color', 'driver.vehicle.year', 'driver.vehicle.brand');

        $data['bid']                = $bid;
        $data['service']            = $driver->service;
        $data['driver_total_ride']  = Ride::where('driver_id', $driver->id)->where('status', Status::RIDE_COMPLETED)->count();
        $data['brand_image_path']   = getFilePath('brand');
        $data['service_image_path'] = getFilePath('service');

        event(new EventsRide("rider-user-$ride->user_id", 'NEW_BID', $data));

        $notify[] = 'Bid placed successfully';
        return apiResponse("bid_success", 'success', $notify, [
            'bid' => $bid
        ]);
    }

    public function cancel($id)
    {
        $ride   = Ride::find($id);

        if (!$ride) {
            $notify[] = "The ride is not available";
            return apiResponse("invalid", "error", $notify);
        }

        $driver = auth()->user();
        $bid    = Bid::where('driver_id', $driver->id)->where('status', Status::BID_PENDING)->where('ride_id', $ride->id)->first();

        if (!$bid) {
            $notify[] = 'The bid is not found';
            return apiResponse("not_found", "error", $notify);
        }

        $bid->status = Status::BID_CANCELED;
        $bid->save();

        $notify[] = 'Bid has been canceled successfully';
        return apiResponse("canceled", "success", $notify, [
            'bid' => $bid
        ]);
    }
}
