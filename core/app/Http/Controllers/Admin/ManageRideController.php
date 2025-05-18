<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Models\Bid;
use App\Models\Ride;
use App\Http\Controllers\Controller;

class ManageRideController extends Controller
{
    public function allRides()
    {
        $pageTitle = 'All Rides';
        extract($this->rideData());
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $rides = $baseQuery->paginate(getPaginate());
        return view('admin.rides.list', compact('pageTitle', 'rides'));
    }

    public function new()
    {
        $pageTitle = 'Pending Rides';
        extract($this->rideData('pending'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $rides = $baseQuery->paginate(getPaginate());
        return view('admin.rides.list', compact('pageTitle', 'rides'));
    }

    public function running()
    {
        $pageTitle = 'Running Rides';
        extract($this->rideData('running'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $rides = $baseQuery->paginate(getPaginate());
        return view('admin.rides.list', compact('pageTitle', 'rides'));
    }

    public function completed()
    {
        $pageTitle = 'Completed Rides';
        extract($this->rideData('completed'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $rides = $baseQuery->paginate(getPaginate());
        return view('admin.rides.list', compact('pageTitle', 'rides'));
    }
    public function canceled()
    {
        $pageTitle = 'Canceled Rides';
        extract($this->rideData('canceled'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $rides = $baseQuery->paginate(getPaginate());
        return view('admin.rides.list', compact('pageTitle', 'rides'));
    }

    protected function rideData($scope = 'query')
    {
        $baseQuery = Ride::$scope()->with(['user', 'driver', 'sosAlert'])->withCount('bids')->searchable(['uid', 'user:username', 'driver:username'])->filter(['user_id', 'driver_id', 'applied_coupon_id','ride_type','service_id'])->orderBy('id', 'desc')->dateFilter();
        
        return [
            'baseQuery' => $baseQuery
        ];
    }
    public function detail($id)
    {
        $pageTitle         = 'Ride Details';
        $ride              = Ride::with(['bids'])->findOrFail($id);
        $totalUserCancel   = Ride::where('user_id', $ride->user_id)->where('status', Status::RIDE_CANCELED)->where('canceled_user_type', Status::USER)->count();
        $totalDriverCancel = Ride::where('driver_id', $ride->driver_id)->where('status', Status::RIDE_CANCELED)->where('canceled_user_type', Status::DRIVER)->count();
        return view('admin.rides.details', compact('pageTitle', 'ride', 'totalUserCancel', 'totalDriverCancel'));
    }

    public function bid($id)
    {
        $ride      = Ride::FindOrFail($id);
        $pageTitle = "Bid List of Ride:" . $ride->uid;
        $bids      = Bid::with('driver')->searchable(['driver:username', 'bid_amount'])->where('ride_id', $ride->id)->paginate(getPaginate());
        return view('admin.rides.bid', compact('pageTitle', 'bids'));
    }


    private function callExportData($baseQuery)
    {
        return exportData($baseQuery, request()->export, "ride", "A4 landscape");
    }
}
