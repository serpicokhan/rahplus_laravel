<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Driver;
use App\Models\Ride;
use App\Models\RidePayment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $userQuery     = User::query();
        $depositQuery  = Deposit::where('driver_id', '!=', 0);
        $withdrawQuery = Withdrawal::where('driver_id', '!=', 0);
        $trxQuery      = Transaction::where('driver_id', '!=', 0);
        $rideQuery     = Ride::query();
        $driverQuery   = Driver::query();
        $paymentQuery  = RidePayment::query();

        $widget['total_payment']        = (clone $paymentQuery)->sum('amount');
        $widget['total_commission']     = (clone $trxQuery)->where('driver_id', '!=', 0)->where('remark', 'ride_commission')->sum('amount');
        $widget['total_cash_payment']   = (clone $paymentQuery)->where('payment_type', Status::PAYMENT_TYPE_CASH)->sum('amount');
        $widget['total_online_payment'] = (clone $paymentQuery)->where('payment_type', Status::PAYMENT_TYPE_GATEWAY)->sum('amount');

        $widget['total_users']             = (clone $userQuery)->count();
        $widget['active_users']            = (clone $userQuery)->active()->count();
        $widget['email_unverified_users']  = (clone $userQuery)->emailUnverified()->count();
        $widget['mobile_unverified_users'] = (clone $userQuery)->mobileUnverified()->count();

        $widget['total_deposit_amount']         = (clone $depositQuery)->successful()->sum('amount');
        $widget['total_deposit_pending']        = (clone $depositQuery)->pending()->sum('amount');
        $widget['total_deposit_pending_count']  = (clone $depositQuery)->pending()->count();
        $widget['total_deposit_rejected']       = (clone $depositQuery)->rejected()->sum('amount');
        $widget['total_deposit_rejected_count'] = (clone $depositQuery)->rejected()->count();
        $widget['total_deposit_charge']         = (clone $depositQuery)->successful()->sum('charge');

        $widget['total_withdraw_amount']         = (clone $withdrawQuery)->approved()->sum('amount');
        $widget['total_withdraw_pending']        = (clone $withdrawQuery)->pending()->sum('amount');
        $widget['total_withdraw_pending_count']  = (clone $withdrawQuery)->pending()->count();
        $widget['total_withdraw_rejected']       = (clone $withdrawQuery)->rejected()->sum('amount');
        $widget['total_withdraw_rejected_count'] = (clone $withdrawQuery)->rejected()->count();
        $widget['total_withdraw_charge']         = (clone $withdrawQuery)->approved()->sum('charge');


        $widget['total_ride']     = (clone $rideQuery)->count();
        $widget['completed_ride'] = (clone $rideQuery)->completed()->count();
        $widget['canceled_ride']  = (clone $rideQuery)->canceled()->count();
        $widget['running_ride']   = (clone $rideQuery)->running()->count();

        $widget['total_driver']             = (clone $driverQuery)->count();
        $widget['active_driver']            = (clone $driverQuery)->active()->count();
        $widget['document_unverified_driver'] = (clone $driverQuery)->where('dv', Status::UNVERIFIED)->count();
        $widget['vehicle_unverified_driver']  = (clone $driverQuery)->where('vv', Status::UNVERIFIED)->count();

        $pageTitle = 'Dashboard';
        $admin     = auth('admin')->user();

        $userLogin = UserLogin::selectRaw('browser, COUNT(*) as total')
            ->groupBy('browser')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.dashboard', compact('pageTitle', 'admin', 'widget', 'userLogin'));
    }

    public function profile()
    {
        $pageTitle = 'My Profile';
        $admin     = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:40',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old         = $user->image;
                $user->image = fileUploader($request->image, getFilePath('admin'), getFileSize('admin'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }

    public function password()
    {
        $pageTitle = 'Change Password';
        $admin     = auth('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|min:6|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.password')->withNotify($notify);
    }

    public function depositAndWithdrawReport(Request $request)
    {
        $today             = Carbon::today();
        $timePeriodDetails = $this->timePeriodDetails($today);
        $timePeriod        = (object) $timePeriodDetails[$request->time_period ?? 'daily'];
        $carbonMethod      = $timePeriod->carbon_method;
        $starDate          = $today->copy()->$carbonMethod($timePeriod->take);
        $endDate           = $today->copy();

        $deposits = Deposit::successful()
            ->where('driver_id', '!=', 0)
            ->whereDate('created_at', '>=', $starDate)
            ->whereDate('created_at', '<=', $endDate)
            ->selectRaw('DATE_FORMAT(created_at, "' . $timePeriod->sql_date_format . '") as date,SUM(amount) as amount')
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();

        $withdrawals = Withdrawal::approved()
            ->where('driver_id', '!=', 0)
            ->whereDate('created_at', '>=', $starDate)
            ->whereDate('created_at', '<=', $endDate)
            ->selectRaw('DATE_FORMAT(created_at, "' . $timePeriod->sql_date_format . '") as date,SUM(amount) as amount')
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();

        $data       = [];

        for ($i = 0; $i < $timePeriod->take; $i++) {
            $date       = $today->copy()->$carbonMethod($i)->format($timePeriod->php_date_format);
            $deposit    = $deposits->where('date', $date)->first();
            $withdrawal = $withdrawals->where('date', $date)->first();

            $depositAmount    = $deposit ? $deposit->amount : 0;
            $withdrawalAmount = $withdrawal ? $withdrawal->amount : 0;

            $data[$date] = [
                'deposited_amount' => $depositAmount,
                'withdrawn_amount' => $withdrawalAmount
            ];
        }
        return response()->json($data);
    }

    public function transactionReport(Request $request)
    {

        $today             = Carbon::today();
        $timePeriodDetails = $this->timePeriodDetails($today);

        $timePeriod        = (object) $timePeriodDetails[$request->time_period ?? 'daily'];
        $carbonMethod      = $timePeriod->carbon_method;
        $starDate          = $today->copy()->$carbonMethod($timePeriod->take);
        $endDate           = $today->copy();

        $plusTransactions   = Transaction::where('trx_type', '+')
            ->where('driver_id', '!=', 0)
            ->whereDate('created_at', '>=', $starDate)
            ->whereDate('created_at', '<=', $endDate)
            ->selectRaw('DATE_FORMAT(created_at, "' . $timePeriod->sql_date_format . '") as date,SUM(amount) as amount')
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();

        $minusTransactions  = Transaction::where('trx_type', '-')
            ->where('driver_id', '!=', 0)
            ->whereDate('created_at', '>=', $starDate)
            ->whereDate('created_at', '<=', $endDate)
            ->selectRaw('DATE_FORMAT(created_at, "' . $timePeriod->sql_date_format . '") as date,SUM(amount) as amount')
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();

        $data = [];

        for ($i = 0; $i < $timePeriod->take; $i++) {
            $date       = $today->copy()->$carbonMethod($i)->format($timePeriod->php_date_format);
            $plusTransaction  = $plusTransactions->where('date', $date)->first();
            $minusTransaction = $minusTransactions->where('date', $date)->first();

            $plusAmount  = $plusTransaction ? $plusTransaction->amount : 0;
            $minusAmount = $minusTransaction ? $minusTransaction->amount : 0;

            $data[$date] = [
                'plus_amount'  => $plusAmount,
                'minus_amount' => $minusAmount
            ];
        }

        return response()->json($data);
    }

    public function notifications()
    {
        $notifications   = AdminNotification::orderBy('id', 'desc')->selectRaw('*,DATE(created_at) as date')->with('user')->paginate(getPaginate());
        $hasUnread       = AdminNotification::where('is_read', Status::NO)->exists();
        $hasNotification = AdminNotification::exists();
        $pageTitle       = 'All Notifications';
        return view('admin.notifications', compact('pageTitle', 'notifications', 'hasUnread', 'hasNotification'));
    }


    public function notificationRead($id)
    {

        $notification          = AdminNotification::findOrFail($id);
        $notification->is_read = Status::YES;
        $notification->save();
        $url = $notification->click_url;
        if ($url == '#') {
            $url = url()->previous();
        }
        return redirect($url);
    }

    public function readAllNotification()
    {
        AdminNotification::where('is_read', Status::NO)->update([
            'is_read' => Status::YES
        ]);
        $notify[] = ['success', 'Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function deleteAllNotification()
    {
        AdminNotification::truncate();
        $notify[] = ['success', 'Notifications deleted successfully'];
        return back()->withNotify($notify);
    }

    public function deleteSingleNotification($id)
    {
        AdminNotification::where('id', $id)->delete();
        $notify[] = ['success', 'Notification deleted successfully'];
        return back()->withNotify($notify);
    }

    private function timePeriodDetails($today): array
    {
        if (request()->date) {
            $date                 = explode('to', request()->date);
            $startDateForCustom   = Carbon::parse(trim($date[0]))->format('Y-m-d');
            $endDateDateForCustom = @$date[1] ? Carbon::parse(trim(@$date[1]))->format('Y-m-d') : $startDateForCustom;
        } else {
            $startDateForCustom   = $today->copy()->subDays(15);
            $endDateDateForCustom = $today->copy();
        }

        return  [
            'daily'   => [
                'sql_date_format' => "%d %b,%Y",
                'php_date_format' => "d M,Y",
                'take'            => 15,
                'carbon_method'   => 'subDays',
                'start_date'      => $today->copy()->subDays(15),
                'end_date'        => $today->copy(),
            ],
            'monthly' => [
                'sql_date_format' => "%b,%Y",
                'php_date_format' => "M,Y",
                'take'            => 12,
                'carbon_method'   => 'subMonths',
                'start_date'      => $today->copy()->subMonths(12),
                'end_date'        => $today->copy(),
            ],
            'yearly'  => [
                'sql_date_format' => '%Y',
                'php_date_format' => 'Y',
                'take'            => 12,
                'carbon_method'   => 'subYears',
                'start_date'      => $today->copy()->subYears(12),
                'end_date'        => $today->copy(),
            ],
            'date_range'   => [
                'sql_date_format' => "%d %b,%Y",
                'php_date_format' => "d M,Y",
                'take'            => (int) Carbon::parse($startDateForCustom)->diffInDays(Carbon::parse($endDateDateForCustom)),
                'carbon_method'   => 'subDays',
                'start_date'      => $startDateForCustom,
                'end_date'        => $endDateDateForCustom,
            ],
        ];
    }

    public function downloadAttachment($fileHash)
    {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title     = slug(gs('site_name')) . '- attachments.' . $extension;

        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error', 'File does not exists'];
            return back()->withNotify($notify);
        }
        
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function showPromotionalNotificationForm()
    {
        $pageTitle = 'Promotional Notification';
        return view('admin.promotional_notification_all', compact('pageTitle'));
    }

    public function sendPromotionalNotificationAll(Request $request)
    {
        $request->validate([
            'user_type' => 'required|in:all,driver,rider',
            'title'     => 'required',
            'message'   => 'required',
            "image"     => ['nullable', new FileTypeValidate(['png', 'jpg', 'jpeg'])]
        ]);

        $files = glob(getFilePath('promotional_notify') . "/*", GLOB_MARK);
        if ($files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }

        $image = null;

        if ($request->hasFile('image')) {
            $image = getImage(getFilePath('promotional_notify') . '/' . fileUploader($request->image, getFilePath('promotional_notify'), getFileSize('promotional_notify')));
        }

        if ($request->user_type == 'driver') {
            $driver = Driver::active()->get();
        } elseif ($request->user_type == 'rider') {
            $users = User::active()->get();
        } else {
            $driver = Driver::active()->get();
            $users  = User::active()->get();
        }

        if ($users ?? false) {
            foreach ($users as $user) {
                notify($user, 'PROMOTIONAL_NOTIFY', [
                    'title'   => $request->title,
                    'message' => $request->message
                ], ['push'], pushImage: $image, createLog: false);
            }
        }

        if ($driver ?? false) {
            foreach ($driver as $driver) {
                notify($driver, 'PROMOTIONAL_NOTIFY', [
                    'title'   => $request->title,
                    'message' => $request->message
                ], ['push'], pushImage: $image, createLog: false);
            }
        }

        $notify[] = ['success', 'Promotional notification send successfully'];
        return back()->withNotify($notify);
    }
}
