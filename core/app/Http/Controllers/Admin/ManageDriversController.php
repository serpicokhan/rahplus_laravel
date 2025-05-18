<?php

namespace App\Http\Controllers\Admin;

use App\Models\Driver;
use App\Constants\Status;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\NotificationLog;
use App\Http\Controllers\Controller;
use App\Lib\UserNotificationSender;
use App\Models\Deposit;
use App\Models\Ride;
use App\Models\RidePayment;
use App\Models\Service;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;


class ManageDriversController extends Controller
{
    public function allDrivers()
    {
        $pageTitle = 'All Drivers';
        extract($this->driverData());
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function activeDrivers()
    {
        $pageTitle = 'Active Drivers';
        extract($this->driverData('active'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function bannedDrivers()
    {
        $pageTitle = 'Banned Drivers';
        extract($this->driverData('banned'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function emailUnverifiedDrivers()
    {
        $pageTitle = 'Email Unverified Drivers';
        extract($this->driverData('emailUnverified'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function unverifiedDrivers()
    {
        $pageTitle = 'Document Unverified Drivers';
        extract($this->driverData('documentUnverified'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function verifyPendingDrivers()
    {
        $pageTitle = 'Driver Verification Pending';
        extract($this->driverData('documentVerifyPending'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function vehicleUnverifiedDrivers()
    {
        $pageTitle = 'Vehicle Unverified Drivers';
        extract($this->driverData("vehicleUnverified"));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function vehiclePendingDrivers()
    {
        $pageTitle = 'Vehicle Verification Pending';
        extract($this->driverData("vehicleVerifyPending"));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function emailVerifiedDrivers()
    {
        $pageTitle = 'Email Verified Drivers';
        extract($this->driverData());
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    public function mobileUnverifiedDrivers()
    {
        $pageTitle = 'Mobile Unverified Drivers';
        extract($this->driverData('mobileUnverified'));
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }


    public function mobileVerifiedDrivers()
    {
        $pageTitle = 'Mobile Verified Drivers';
        extract($this->driverData());
        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $drivers = $baseQuery->paginate(getPaginate());
        return view('admin.driver.list', compact('pageTitle', 'drivers', 'widget'));
    }

    protected function driverData($scope = "query")
    {
        $baseQuery  = Driver::$scope()->with('ride')->searchable(['email', 'username', 'firstname', 'lastname'])->dateFilter()->filter(['status'])->orderBy('id', getOrderBy());
        $countQuery = Driver::query();

        $widget['all']   = (clone $countQuery)->count();
        $widget['today'] = (clone $countQuery)->whereDate('created_at', now())->count();
        $widget['week']  = (clone $countQuery)->whereDate('created_at', ">=", now()->subDays(7))->count();
        $widget['month'] = (clone $countQuery)->whereDate('created_at', ">=", now()->subDays(30))->count();

        return [
            'baseQuery' => $baseQuery,
            'widget'    => $widget
        ];
    }


    public function detail($id)
    {
        $driver    = Driver::with('vehicle')->findOrFail($id);
        $pageTitle = 'Driver Detail - ' . $driver->username;
        $loginLogs = UserLogin::where('driver_id', $driver->id)->take(6)->get();
        $services  = Service::get();



        $widget['total_deposit']  = Deposit::where('driver_id', $driver->id)->successful()->sum('amount');
        $widget['total_payment']  = RidePayment::where('driver_id', $driver->id)->sum('amount');
        $widget['total_withdraw'] = Withdrawal::where('driver_id', $driver->id)->approved()->sum('amount');
        $countries                = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $rideQuery = Ride::where('driver_id', $driver->id);

        $widget['total_ride']     = (clone $rideQuery)->count();
        $widget['completed_ride'] = (clone $rideQuery)->completed()->count();
        $widget['canceled_ride']  = (clone $rideQuery)->canceled()->count();
        $widget['running_ride']   = (clone $rideQuery)->running()->count();


        return view('admin.driver.detail', compact('pageTitle', 'driver', 'widget', 'countries', 'loginLogs', 'services'));
    }

    public function verificationApprove($id)
    {
        $driver     = Driver::findOrFail($id);
        $driver->dv = Status::VERIFIED;
        $driver->save();

        notify($driver, 'DRIVER_DOCUMENT_APPROVE', []);
        $notify[] = ['success', 'Driver verification approved successfully'];
        return back()->withNotify($notify);
    }

    public function verificationReject($id)
    {
        $driver     = Driver::findOrFail($id);
        $driver->dv = Status::UNVERIFIED;
        $driver->save();

        notify($driver, 'DRIVER_DOCUMENT_REJECT', []);

        $notify[] = ['success', 'Driver information has been rejected'];
        return back()->withNotify($notify);
    }


    public function vehicleApprove($id)
    {
        $driver     = Driver::findOrFail($id);
        $driver->vv = Status::VERIFIED;
        $driver->save();

        notify($driver, 'VEHICLE_VERIFY_APPROVE', []);
        $notify[] = ['success', 'Vehicle information approved successfully'];
        return back()->withNotify($notify);
    }

    public function vehicleReject($id)
    {
        $driver     = Driver::find($id);
        $driver->vv = Status::UNVERIFIED;
        $driver->save();

        notify($driver, 'VEHICLE_VERIFY_REJECT', []);

        $notify[] = ['success', 'Vehicle information has been rejected'];
        return back()->withNotify($notify);
    }


    public function rideRules($id)
    {
        $pageTitle = 'Ride Rules';
        $driver    = Driver::findOrFail($id);
        return view('admin.driver.rules_detail', compact('pageTitle', 'driver', 'widget'));
    }


    public function update(Request $request, $id)
    {
        $driver         = Driver::findOrFail($id);
        $countryData  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray = (array)$countryData;
        $countries    = implode(',', array_keys($countryArray));

        $countryCode = $request->country;
        $country     = $countryData->$countryCode->country;
        $dialCode    = $countryData->$countryCode->dial_code;

        $request->validate([
            'firstname' => 'required|string|max:40',
            'lastname'  => 'required|string|max:40',
            'email'     => 'required|email|string|max:40|unique:drivers,email,' . $driver->id,
            'mobile'    => 'required|string|max:40',
            'service'   => 'nullable|integer|exists:drivers,id',
            'country'   => 'required|in:' . $countries,
        ]);

        $exists = Driver::where('mobile', $request->mobile)->where('dial_code', $dialCode)->where('id', '!=', $driver->id)->exists();

        if ($exists) {
            $notify[] = ['error', 'The mobile number already exists.'];
            return back()->withNotify($notify);
        }

        $driver->mobile    = $request->mobile;
        $driver->firstname = $request->firstname;
        $driver->lastname  = $request->lastname;
        $driver->email     = $request->email;

        $driver->address      = $request->address;
        $driver->city         = $request->city;
        $driver->state        = $request->state;
        $driver->zip          = $request->zip;
        $driver->service_id   = $request->service ?? 0;
        $driver->country_name = @$country;
        $driver->dial_code    = $dialCode;
        $driver->country_code = $countryCode;

        $driver->ev = $request->ev ? Status::VERIFIED : Status::UNVERIFIED;
        $driver->sv = $request->sv ? Status::VERIFIED : Status::UNVERIFIED;
        $driver->ts = $request->ts ? Status::ENABLE : Status::DISABLE;
        $driver->vv = $request->vv ? Status::VERIFIED : Status::UNVERIFIED;
        $driver->dv = $request->dv ? Status::VERIFIED : Status::UNVERIFIED;
        $driver->save();

        $notify[] = ['success', 'Driver details updated successfully'];
        return back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'act'    => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
        ]);

        $driver = Driver::findOrFail($id);
        $amount = $request->amount;
        $trx    = getTrx();

        $transaction = new Transaction();

        if ($request->act == 'add') {
            $driver->balance += $amount;

            $transaction->trx_type = '+';
            $transaction->remark   = 'balance_add';
            $notifyTemplate        = 'BAL_ADD';
            $message               = 'Balance added successfully';
        } else {
            if ($amount > $driver->balance) {
                $notify[] = ['error', $driver->username . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

            $driver->balance -= $amount;

            $transaction->trx_type = '-';
            $transaction->remark   = 'balance_subtract';
            $notifyTemplate        = 'BAL_SUB';
            $message               = 'Balance subtracted successfully';
        }

        $driver->save();

        $transaction->driver_id    = $driver->id;
        $transaction->amount       = $amount;
        $transaction->post_balance = $driver->balance;
        $transaction->charge       = 0;
        $transaction->trx          = $trx;
        $transaction->details      = $request->remark;
        $transaction->save();

        notify($driver, $notifyTemplate, [
            'trx'          => $trx,
            'amount'       => showAmount($amount, currencyFormat: false),
            'remark'       => $request->remark,
            'post_balance' => showAmount($driver->balance, currencyFormat: false)
        ]);

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function status(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        if ($driver->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            $driver->status     = Status::USER_BAN;
            $driver->ban_reason = $request->reason;
            $notify[]           = ['success', 'Driver banned successfully'];
        } else {
            $driver->status     = Status::USER_ACTIVE;
            $driver->ban_reason = null;
            $notify[]           = ['success', 'Driver unbanned successfully'];
        }
        $driver->save();
        return back()->withNotify($notify);
    }


    public function showNotificationSingleForm($id)
    {
        $driver  = Driver::findOrFail($id);
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.rider.detail', $user->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $driver->username;
        return view('admin.driver.notification_single', compact('pageTitle', 'driver'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {

        $request->validate([
            'message' => 'required',
            'via'     => 'required|in:email,sms,push',
            'subject' => 'required_if:via,email,push',
            'image'   => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }
        $notificationSender = new UserNotificationSender(Driver::class);
        return $notificationSender->notificationToSingle($request, $id);
    }

    public function showNotificationAllForm()
    {
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $notifyToDriver = Driver::notifyToDriver();
        $drivers        = Driver::active()->count();
        $pageTitle      = 'Notification to Verified Drivers';
        return view('admin.driver.notification_all', compact('pageTitle', 'drivers', 'notifyToDriver'));
    }

    public function sendNotificationAll(Request $request)
    {
        $request->validate([
            'via'                            => 'required|in:email,sms,push',
            'message'                        => 'required',
            'subject'                        => 'required_if:via,email,push',
            'start'                          => 'required|integer|gte:1',
            'batch'                          => 'required|integer|gte:1',
            'being_sent_to'                  => 'required',
            'cooling_time'                   => 'required|integer|gte:1',
            'number_of_top_deposited_driver' => 'required_if:being_sent_to,topDepositedUsers|integer|gte:0',
            'number_of_days'                 => 'required_if:being_sent_to,notLoginUsers|integer|gte:0',
            'image'                          => ["nullable", 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'number_of_days.required_if'                 => "Number of days field is required",
            'number_of_top_deposited_driver.required_if' => "Number of top deposited user field is required",
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        return (new UserNotificationSender(Driver::class))->notificationToAll($request);
    }

    public function list()
    {
        $query = Driver::active();

        if (request()->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . request()->search . '%')->orWhere('username', 'like', '%' . request()->search . '%');
            });
        }

        $drivers = $query->orderBy('id', 'desc')->paginate(getPaginate());
        return response()->json([
            'success' => true,
            'drivers' => $drivers,
            'more'    => $drivers->hasMorePages()
        ]);
    }

    public function notificationLog($id)
    {
        $driver    = Driver::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $driver->username;
        $logs      = NotificationLog::where('driver_id', $id)->with('driver')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.driver_reports.notification_history', compact('pageTitle', 'logs', 'driver', 'widget'));
    }

    public function deleteAccount($id)
    {
        $driver = Driver::findOrFail($id);

        if ($driver->is_deleted == Status::NO) {
            $driver->is_deleted = Status::YES;
            $notify[]           = ['success', 'Driver account deleted successfully'];
        } else {
            $driver->is_deleted = Status::NO;
            $notify[]           = ['success', 'Driver account recovered successfully'];
        }

        $driver->save();
        return back()->withNotify($notify);
    }

    private function callExportData($baseQuery)
    {
        return exportData($baseQuery, request()->export, "driver", "A4 landscape");
    }

    public function countBySegment($methodName)
    {

        return Driver::active()->$methodName()->count();
    }
}
