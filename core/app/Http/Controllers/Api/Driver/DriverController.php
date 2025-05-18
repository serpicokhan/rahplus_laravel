<?php

namespace App\Http\Controllers\Api\Driver;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Brand;
use App\Models\DeviceToken;
use App\Models\Form;
use App\Models\Ride;
use App\Models\RidePayment;
use App\Models\RiderRule;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Zone;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Lib\GoogleAuthenticator;
use App\Models\Review;
use App\Models\Vehicle;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use App\Models\VehicleYear;

class DriverController extends Controller
{
    public function dashboard()
    {
        $driver = auth()->user();

        if ($driver->online_status  == Status::YES && $driver->dv == Status::VERIFIED && $driver->vv == Status::VERIFIED) {
            $rides = Ride::where('pickup_zone_id', $driver->zone_id)
                ->pending()
                ->where('service_id', @$driver->service_id)
                ->whereDoesntHave('bids', function ($q) use ($driver) {
                    $q->where("driver_id", $driver->id)->whereNotIn('status', [Status::BID_CANCELED, Status::BID_REJECTED]);
                })
                ->with('user', 'service')
                ->latest('id')
                ->paginate(getPaginate());
        } else {
            $rides = null;
        }

        $runningRide  = Ride::running()->where('driver_id', $driver->id)->with('user', 'service')->first();
        $pendingRides = Ride::pending()->where('driver_id', $driver->id)->with('user', 'service')->get();
        $notify[]     = 'Dashboard data';

        return apiResponse("driver_dashboard", "success", $notify, [
            'rides'             => $rides,
            'running_rides'     => $runningRide,
            'pending_rides'     => $pendingRides,
            'driver'            => $driver->load('vehicle'),
            'driver_image_path' => getFilePath('driver'),
            'user_image_path'   => getFilePath('user')
        ]);
    }

    public function onlineStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat'  => 'required',
            'long' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $zones      = Zone::active()->get();
        $address    = ['lat' => $request->lat, 'long' => $request->long];
        $driverZone = null;

        foreach ($zones as $zone) {
            if (insideZone($address, $zone)) {
                $driverZone = $zone;
                break;
            }
        }

        $driver                = auth()->user();
        $driver->online_status = !$driver->online_status;

        if ($driverZone) {
            $driver->zone_id = $driverZone->id;
        }

        $driver->save();
        $notify[] = $driver->online_status ? 'You are online' : 'You are offline';

        return apiResponse("online_status", "success", $notify, [
            'online' => (bool) $driver->online_status
        ]);
    }

    public function driverInfo()
    {
        $notify[] = 'User information';
        $driver   = auth()->user();

        return  apiResponse("driver_dashboard", "success", $notify, [
            'driver'            => $driver->makeVisible('balance'),
            'driver_data'       => $driver->driver_data,
            'vehicle'           => $driver->vehicle ?? null,
            'driver_image_path' => getFilePath('driver')
        ]);
    }

    public function driverVerification()
    {
        $driver = auth()->user('driver');

        if ($driver->dv == Status::PENDING) {
            $notify[] = 'We are currently reviewing your driver information.';
            return apiResponse("under_review", "success", $notify, [
                'driver_data' => $driver->driver_data,
                'file_path'   => getFilePath('verify')
            ]);
        }

        if ($driver->dv == Status::VERIFIED) {
            $notify[] = 'You have already completed the driver verification process successfully.';
            return apiResponse("already_verified", "success", $notify, [
                'driver_data' => $driver->driver_data,
                'file_path'   => getFilePath('verify')
            ]);
        }

        $form     = Form::where('act', 'driver_verification')->first();
        $notify[] = 'Driver verification field is below';

        return apiResponse("vehicle_form", "success", $notify, [
            'form'      => $form->form_data,
            'file_path' => getFilePath('verify'),
        ]);
    }
    public function driverVerificationStore(Request $request)
    {
        $form           = Form::where('act', 'driver_verification')->first();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $validator      = Validator::make($request->all(), $validationRule);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $driver = auth()->user('driver');

        if ($driver->dv == Status::PENDING) {
            $notify[] = 'We are currently reviewing your driver information.';
            return apiResponse("under_review", "success", $notify, [
                'driver_data' => $driver->driver_data,
                'file_path'   => getFilePath('verify')
            ]);
        }

        $driverData = $formProcessor->processFormData($request, $formData);

        $driver->driver_data = $driverData;
        $driver->dv          = Status::PENDING;
        $driver->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->driver_id = $driver->id;
        $adminNotification->title     = 'Driver Verification';
        $adminNotification->click_url = urlPath('admin.driver.verify.pending');
        $adminNotification->save();

        $notify[] = 'Driver verification information submitted successfully';

        return apiResponse("verification_submitted", "success", $notify);
    }

    public function depositHistory(Request $request)
    {
        $deposits = auth()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx', $request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        $notify[] = 'Deposit data';

        return apiResponse("deposits", "success", $notify, [
            'deposits' => $deposits
        ]);
    }

    public function transactions(Request $request)
    {
        $remarks      = Transaction::where('driver_id', '!=', 0)->distinct('remark')->get('remark');
        $transactions = Transaction::where('driver_id', auth()->user('driver')->id ?? 0);

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $type         = $request->type == 'plus' ? '+' : '-';
            $transactions = $transactions->where('trx_type', $type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        $notify[]     = 'Transactions data';

        return apiResponse("transactions", "success", $notify, [
            'transactions' => $transactions,
            'remarks'      => $remarks,
        ]);
    }
    public function paymentHistory()
    {
        $payments = RidePayment::where('driver_id', auth()->id())->orderBy('id', 'desc')->with('rider', 'ride')->paginate(getPaginate());
        $notify[] = 'Payment Data';

        return apiResponse("payments", "success", $notify, [
            'payments' => $payments,
        ]);
    }

    public function pusher($socketId, $channelName)
    {
        $general      = gs();
        $pusherSecret = $general->pusher_config->app_secret;
        $str          = $socketId . ":" . $channelName;
        $hash         = hash_hmac('sha256', $str, $pusherSecret);

        return response()->json([
            'auth' => $general->pusher_config->app_key . ":" . $hash,
        ]);
    }

    public function driverDataSubmit(Request $request)
    {
        $driver = auth()->user();

        if ($driver->profile_complete == Status::YES) {
            $notify[] = 'You\'ve already completed your profile';
            return apiResponse("already_completed", "error", $notify);
        }

        $countryData  = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));


        $validator = Validator::make($request->all(), [
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'zone'         => 'required|integer',
            'username'     => 'required|unique:drivers,username|min:6',
            'mobile'       => ['required', 'regex:/^([0-9]*)$/', Rule::unique('users')->where('dial_code', $request->mobile_code)],
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = 'No special character, space or capital letters in username';
            return apiResponse("validation_error", "error", $notify);
        }

        $zone = Zone::active()->where('id', $request->zone)->first();

        if (!$zone) {
            $notify[] = 'The zone not found';
            return apiResponse("not_found", "error", $notify);
        }

        $driver->country_code = $request->country_code;
        $driver->mobile       = $request->mobile;
        $driver->username     = $request->username;
        $driver->address      = $request->address;
        $driver->city         = $request->city;
        $driver->state        = $request->state;
        $driver->zip          = $request->zip;
        $driver->country_name = @$request->country;
        $driver->dial_code    = $request->mobile_code;
        $driver->zone_id      = $request->zone;

        $driver->profile_complete = Status::YES;
        $driver->save();

        $notify[] = 'Profile completed successfully';

        return apiResponse("profile_completed", "success", $notify, [
            'driver' => $driver
        ]);
    }

    public function vehicleVerification()
    {
        $driver = auth()->user();

        if ($driver->vv == Status::VERIFIED) {
            $notify[] = 'Vehicle information already verified';
            return apiResponse("verified", "error", $notify);
        }

        if ($driver->vv == Status::PENDING) {
            $notify[] = 'We are currently reviewing your vehicle information.';

            $driver->load('vehicle', 'vehicle.model', 'vehicle.color', 'vehicle.year', 'vehicle.brand', 'service');
            $vehicle = $driver->vehicle;

            return apiResponse("under_review", "success", $notify, [
                'vehicle'            => $vehicle,
                'vehicle_data'       => $vehicle->form_data,
                'service'            => $driver->service,
                'file_path'          => getFilePath('verify'),
                'service_image_path' => getFilePath('service'),
                'brand_image_path'   => getFilePath('brand'),
            ]);
        }

        if ($driver->vv == Status::VERIFIED) {
            $notify[] = 'You have already completed the vehicle verification process successfully.';
            return apiResponse("already_verified", "success", $notify);
        }

        $form     = Form::where('act', 'vehicle_verification')->first();
        $notify[] = 'Vehicle verification field is below';

        $brands = Brand::active()->with('models', function ($q) {
            $q->active();
        })->get();

        return apiResponse("vehicle_form", "success", $notify, [
            'form'               => $form->form_data,
            'services'           => Service::active()->get(),
            'brands'             => $brands,
            'colors'             => VehicleColor::active()->get(),
            'years'              => VehicleYear::active()->get(),
            'rider_rules'        => RiderRule::active()->get(),
            'file_path'          => getFilePath('verify'),
            'service_image_path' => getFilePath('service'),
            'brand_image_path'   => getFilePath('brand'),
        ]);
    }

    public function vehicleVerificationStore(Request $request)
    {

        $driver = auth()->user();

        if ($driver->vv == Status::VERIFIED || $driver->vv == Status::PENDING) {
            $notify[] = 'Your vehicle information is already verified';
            return apiResponse("verified", "error", $notify);
        }

        $rule = [
            'service_id'     => 'required|integer',
            'brand_id'       => 'required|integer',
            'model'          => 'required',
            'year'           => 'required',
            'color'          => 'required',
            'vehicle_number' => 'required|unique:vehicles,vehicle_number',
            'rules'          => 'required|array',
            'rules.*'        => 'required|integer|exists:rider_rules,id',
            'image'          => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ];

        $form           = Form::where('act', 'vehicle_verification')->first();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);

        $validator = Validator::make($request->all(), array_merge($validationRule, $rule));

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $service = Service::active()->find($request->service_id);

        if (!$service) {
            $notify[] = 'Service currently unavailable';
            return apiResponse("not_found", "error", $notify);
        }

        $brand = Brand::active()->find($request->brand_id);

        if (!$brand) {
            $notify[] = 'Brand not found';
            return apiResponse("not_found", "error", $notify);
        }

        $model = VehicleModel::where('name', $request->model)->where('brand_id', $brand->id)->first();

        if (!$model) {
            $model           = new VehicleModel();
            $model->name     = $request->model;
            $model->brand_id = $brand->id;
            $model->save();
        } else {
            if ($model->status == Status::DISABLE) {
                $notify[] = 'The model is not available at the moment';
                return apiResponse("not_found", "error", $notify);
            }
        }
        $year = VehicleYear::where('name', $request->year)->first();
        if (!$year) {
            $year       = new VehicleYear();
            $year->name = $request->year;
            $year->save();
        } else {
            if ($year->status == Status::DISABLE) {
                $notify[] = 'The year is not available';
                return apiResponse("not_found", "error", $notify);
            }
        }

        $color = VehicleColor::active()->where('name', $request->color)->first();

        if (!$color) {
            $color       = new VehicleColor();
            $color->name = $request->color;
            $color->save();
        } else {
            if ($color->status == Status::DISABLE) {
                $notify[] = 'The color is not available at the moment';
                return apiResponse("not_found", "error", $notify);
            }
        }

        $vehicleData = $formProcessor->processFormData($request, $formData);

        $vehicle = Vehicle::where('driver_id', $driver->id)->first();

        if (!$vehicle) {
            $vehicle            = new Vehicle();
            $vehicle->driver_id = $driver->id;
        }

        $vehicle->model_id       = $model->id;
        $vehicle->color_id       = $color->id;
        $vehicle->year_id        = $year->id;
        $vehicle->brand_id       = $brand->id;
        $vehicle->service_id     = $service->id;
        $vehicle->form_data      = $vehicleData;
        $vehicle->vehicle_number = $request->vehicle_number;

        if ($request->hasFile('image')) {
            try {
                $vehicle->image = fileUploader($request->image, getFilePath('vehicle'));
            } catch (\Exception $exp) {
                $notify[] = 'Couldn\'t upload your image';
                return apiResponse("not_found", "error", $notify);
            }
        }

        $vehicle->save();

        $driver->service_id    = $request->service_id;
        $driver->rider_rule_id = $request->rules ?? [];
        $driver->vv            = Status::PENDING;
        $driver->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->driver_id = $driver->id;
        $adminNotification->title     = 'Vehicle Verification';
        $adminNotification->click_url = urlPath('admin.driver.vehicle.verify.pending');
        $adminNotification->save();

        $notify[] = 'Vehicle verification data submitted successfully';
        return apiResponse("vehicle_info_submitted", "success", $notify);
    }

    public function submitProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname'  => 'required',
            'image'     => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required'  => 'The last name field is required'
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $user            = auth()->user();
        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->address   = $request->address;
        $user->city      = $request->city;
        $user->state     = $request->state;
        $user->zip       = $request->zip;

        if ($request->hasFile('image')) {
            try {
                $user->image = fileUploader($request->image, getFilePath('driver'), getFileSize('driver'), $user->driver);
            } catch (\Exception $exp) {
                $notify[] = 'Couldn\'t upload your image';
                return apiResponse('exception', 'error', $notify);
            }
        }

        $user->save();

        $notify[] = 'Profile updated successfully';

        return apiResponse("profile_updated", "success", $notify);
    }

    public function submitPassword(Request $request)
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', $passwordValidation]
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password       = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = 'Password changed successfully';
            return apiResponse("password_changed", "success", $notify);
        } else {
            $notify[] = 'The password doesn\'t match!';
            return apiResponse("not_match", "validation_error", $notify);
        }
    }

    public function accountDelete()
    {
        $driver             = auth()->user();
        $driver->is_deleted = Status::YES;
        $driver->save();

        $driver->tokens()->where('id', $driver->currentAccessToken()->id)->delete();

        $notify[] = 'Account deleted successfully';
        return apiResponse("account_delete", 'success', $notify);
    }

    public function addDeviceToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $driverId = auth()->user()->id;

        $deviceToken = DeviceToken::where('token', $request->token)->where('driver_id', $driverId)->first();

        if ($deviceToken) {
            $notify[] = 'Token already exists';
            return apiResponse("token_exists", "error", $notify);
        }

        $deviceToken            = new DeviceToken();
        $deviceToken->driver_id = auth()->user()->id;
        $deviceToken->token     = $request->token;
        $deviceToken->is_app    = Status::YES;
        $deviceToken->save();

        $notify[] = 'Token saved successfully';
        return apiResponse("token_saved", "success", $notify);
    }


    public function show2faForm()
    {
        $ga        = new GoogleAuthenticator();
        $user      = auth()->user();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $notify[]  = '2FA Qr';

        return apiResponse("2fa_qr", "success", $notify, [
            'secret'      => $secret,
            'qr_code_url' => $qrCodeUrl,
        ]);
    }

    public function create2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'code'   => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $user     = auth()->user();
        $response = verifyG2fa($user, $request->code, $request->secret);
        if ($response) {
            $user->tsc = $request->secret;
            $user->ts  = Status::ENABLE;
            $user->save();

            $notify[] = 'Google authenticator activated successfully';
            return apiResponse("2fa_qr", "success", $notify);
        } else {
            $notify[] = 'Wrong verification code';
            return apiResponse("wrong_verification", "error", $notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $user     = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts  = Status::DISABLE;
            $user->save();
            $notify[] = 'Two factor authenticator deactivated successfully';
            return apiResponse("2fa_qr", "success", $notify);
        } else {
            $notify[] = 'Wrong verification code';
            return apiResponse("wrong_verification", "error", $notify);
        }
    }


    public function review()
    {
        $notify[]        = 'Driver Review List';
        return apiResponse("review", "success", $notify, [
            'user_image_path'   => getFilePath('user'),
            'driver_image_path' => getFilePath('driver'),
            "reviews"           => Review::with("user")->latest('id')->where('driver_id', auth()->id())->get()
        ]);
    }
}
