<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\UserNotificationSender;
use App\Models\NotificationLog;
use App\Models\Ride;
use App\Models\RidePayment;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;

class ManageRiderController extends Controller
{
    public function allUsers()
    {
        $pageTitle = 'All Riders';
        extract($this->userData());

        if (request()->export) {
            return $this->callExportData($baseQuery);
        }

        $users = $baseQuery->paginate(getPaginate());
        return view('admin.rider.list', compact('pageTitle', 'users', 'widget'));
    }

    public function activeUsers()
    {
        $pageTitle = 'Active Riders';
        extract($this->userData("active"));

        if (request()->export) {
            return $this->callExportData($baseQuery);
        }

        $users = $baseQuery->paginate(getPaginate());
        return view('admin.rider.list', compact('pageTitle', 'users', 'widget'));
    }

    public function bannedUsers()
    {
        $pageTitle = 'Banned Riders';
        extract($this->userData("banned"));

        if (request()->export) {
            return $this->callExportData($baseQuery);
        }

        $users = $baseQuery->paginate(getPaginate());
        return view('admin.rider.list', compact('pageTitle', 'users', 'widget'));
    }

    public function emailUnverifiedUsers()
    {
        $pageTitle = 'Email Unverified Riders';
        extract($this->userData('emailUnverified'));

        if (request()->export) {
            return $this->callExportData($baseQuery);
        }

        $users = $baseQuery->paginate(getPaginate());
        return view('admin.rider.list', compact('pageTitle', 'users', 'widget'));
    }



    public function emailVerifiedUsers()
    {
        $pageTitle = 'Email Verified Riders';
        extract($this->userData('emailVerified'));

        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $users = $baseQuery->paginate(getPaginate());

        return view('admin.rider.list', compact('pageTitle', 'users', 'widget'));
    }


    public function mobileUnverifiedUsers()
    {
        $pageTitle = 'Mobile Unverified Riders';
        extract($this->userData('mobileUnverified'));

        if (request()->export) {
            return $this->callExportData($baseQuery);
        }
        $users = $baseQuery->paginate(getPaginate());

        return view('admin.rider.list', compact('pageTitle', 'users', 'widget'));
    }

    public function mobileVerifiedUsers()
    {
        $pageTitle = 'Mobile Verified Riders';
        extract($this->userData('mobileVerified'));

        if (request()->export) {
            return $this->callExportData($baseQuery);
        }

        $users = $baseQuery->paginate(getPaginate());
        return view('admin.rider.list', compact('pageTitle', 'users', 'widget'));
    }



    protected function userData($scope = 'query')
    {
        $baseQuery  = User::$scope()->with('rides')->searchable(['email', 'username', 'firstname', 'lastname'])->dateFilter()->filter(['status'])->orderBy('id', getOrderBy());
        $countQuery = User::query();

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
        $user      = User::findOrFail($id);
        $pageTitle = 'Rider Detail - ' . $user->username;
        $loginLogs = UserLogin::where('user_id', $user->id)->take(6)->get();

        $paymentQuery = RidePayment::where('rider_id', $user->id);

        $widget['total_payment']         = (clone $paymentQuery)->sum('amount');
        $widget['total_payment_cash']    = (clone $paymentQuery)->where('payment_type', Status::PAYMENT_TYPE_CASH)->sum('amount');
        $widget['total_payment_gateway'] = (clone $paymentQuery)->where('payment_type', Status::PAYMENT_TYPE_GATEWAY)->sum('amount');
        $widget['last_payment_amount']   = @(clone $paymentQuery)->orderBy('id', 'desc')->first()->amount ?? 0;

        $rideQuery = Ride::where('user_id', $user->id);

        $widget['total_ride']     = (clone $rideQuery)->count();
        $widget['completed_ride'] = (clone $rideQuery)->completed()->count();
        $widget['canceled_ride']  = (clone $rideQuery)->canceled()->count();
        $widget['running_ride']   = (clone $rideQuery)->running()->count();

        $countries                   = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('admin.rider.detail', compact('pageTitle', 'user', 'widget', 'countries', 'loginLogs'));
    }


    public function update(Request $request, $id)
    {
        $user         = User::findOrFail($id);
        $countryData  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray = (array)$countryData;
        $countries    = implode(',', array_keys($countryArray));

        $countryCode = $request->country;
        $country     = $countryData->$countryCode->country;
        $dialCode    = $countryData->$countryCode->dial_code;

        $request->validate([
            'firstname' => 'required|string|max:40',
            'lastname'  => 'required|string|max:40',
            'email'     => 'required|email|string|max:40|unique:users,email,' . $user->id,
            'mobile'    => 'required|string|max:40',
            'country'   => 'required|in:' . $countries,
        ]);

        $exists = User::where('mobile', $request->mobile)->where('dial_code', $dialCode)->where('id', '!=', $user->id)->exists();

        if ($exists) {
            $notify[] = ['error', 'The mobile number already exists.'];
            return back()->withNotify($notify);
        }

        $user->mobile    = $request->mobile;
        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->email     = $request->email;

        $user->address      = $request->address;
        $user->city         = $request->city;
        $user->state        = $request->state;
        $user->zip          = $request->zip;
        $user->country_name = @$country;
        $user->dial_code    = $dialCode;
        $user->country_code = $countryCode;

        $user->ev = $request->ev ? Status::VERIFIED : Status::UNVERIFIED;
        $user->sv = $request->sv ? Status::VERIFIED : Status::UNVERIFIED;
        $user->save();

        $notify[] = ['success', 'Rider details updated successfully'];
        return back()->withNotify($notify);
    }

    public function status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            $user->status     = Status::USER_BAN;
            $user->ban_reason = $request->reason;
            $notify[]         = ['success', 'Rider banned successfully'];
        } else {
            $user->status     = Status::USER_ACTIVE;
            $user->ban_reason = null;
            $notify[]         = ['success', 'Rider unbanned successfully'];
        }
        $user->save();
        return back()->withNotify($notify);
    }
    public function showNotificationSingleForm($id)
    {
        $user = User::findOrFail($id);
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.rider.detail', $user->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $user->username;
        return view('admin.rider.notification_single', compact('pageTitle', 'user'));
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
        return (new UserNotificationSender())->notificationToSingle($request, $id);
    }

    public function showNotificationAllForm()
    {
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $notifyToUser = User::notifyToUser();
        $users        = User::active()->count();
        $pageTitle    = 'Notification to Verified Riders';

        if (session()->has('SEND_NOTIFICATION') && !request()->email_sent) {
            session()->forget('SEND_NOTIFICATION');
        }

        return view('admin.rider.notification_all', compact('pageTitle', 'users', 'notifyToUser'));
    }

    public function sendNotificationAll(Request $request)
    {
        $request->validate([
            'via'                          => 'required|in:email,sms,push',
            'message'                      => 'required',
            'subject'                      => 'required_if:via,email,push',
            'start'                        => 'required|integer|gte:1',
            'batch'                        => 'required|integer|gte:1',
            'being_sent_to'                => 'required',
            'cooling_time'                 => 'required|integer|gte:1',
            'number_of_top_deposited_user' => 'required_if:being_sent_to,topDepositedUsers|integer|gte:0',
            'number_of_days'               => 'required_if:being_sent_to,notLoginUsers|integer|gte:0',
            'image'                        => ["nullable", 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'number_of_days.required_if'               => "Number of days field is required",
            'number_of_top_deposited_user.required_if' => "Number of top deposited user field is required",
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        return (new UserNotificationSender())->notificationToAll($request);
    }


    public function countBySegment($methodName)
    {

        return User::active()->$methodName()->count();
    }

    public function list()
    {
        $query = User::active();
        $users = $query->searchable(['email', 'username'])->orderBy('id', 'desc')->paginate(getPaginate());

        return response()->json([
            'success' => true,
            'users'   => $users,
            'more'    => $users->hasMorePages()
        ]);
    }

    public function notificationLog($id)
    {
        $user      = User::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $user->username;
        $logs      = NotificationLog::where('user_id', $id)->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs', 'user'));
    }

    private function callExportData($baseQuery)
    {
        return exportData($baseQuery, request()->export, "user", "A4 landscape");
    }
}
