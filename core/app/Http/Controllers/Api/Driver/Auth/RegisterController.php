<?php

namespace App\Http\Controllers\Api\Driver\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Driver;
use App\Models\UserLogin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        $agree = 'nullable';
        if (gs('agree')) {
            $agree = 'required';
        }

        $validate     = Validator::make($data, [
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|string|email|unique:drivers',
            'password'  => ['required', 'confirmed', $passwordValidation],
            'agree'     => $agree,
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required'  => 'The last name field is required'
        ]);

        return $validate;
    }


    public function register(Request $request)
    {
        if (!gs('driver_registration')) {
            $notify[] = 'Registration not allowed';
            return apiResponse("registration_disabled", "error", $notify);
        }

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }



        $driver = $this->create($request->all());

        $data['access_token'] = $driver->createToken('driver_token')->plainTextToken;
        $data['driver']       = $driver;
        $data['token_type']   = 'Bearer';
        $data['image_path']   = getFilePath('driver');
        $notify[]             = 'Registration successful';

        return apiResponse("registration_success", "success", $notify,  $data);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $driver            = new Driver();
        $driver->firstname = $data['firstname'];
        $driver->lastname  = $data['lastname'];
        $driver->email     = strtolower($data['email']);
        $driver->password  = Hash::make($data['password']);
        $driver->ev        = gs('ev') ? Status::UNVERIFIED : Status::VERIFIED;
        $driver->sv        = gs('sv') ? Status::UNVERIFIED : Status::VERIFIED;
        $driver->ts        = Status::DISABLE;
        $driver->tv        = Status::VERIFIED;

        $driver->save();


        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = 0;
        $adminNotification->driver_id = $driver->id;
        $adminNotification->title     = 'New driver registered';
        $adminNotification->click_url = urlPath('admin.driver.detail', $driver->id);
        $adminNotification->save();


        //Login Log Create
        $ip        = getRealIP();
        $exist     = UserLogin::where('user_ip', $ip)->where('driver_id', $driver->id)->first();
        $driverLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $driverLogin->longitude    = $exist->longitude;
            $driverLogin->latitude     = $exist->latitude;
            $driverLogin->city         = $exist->city;
            $driverLogin->country_code = $exist->country_code;
            $driverLogin->country      = $exist->country;
        } else {
            $info                    = json_decode(json_encode(getIpInfo()), true);
            $driverLogin->longitude    = @implode(',', $info['long']);
            $driverLogin->latitude     = @implode(',', $info['lat']);
            $driverLogin->city         = @implode(',', $info['city']);
            $driverLogin->country_code = @implode(',', $info['code']);
            $driverLogin->country      = @implode(',', $info['country']);
        }

        $driverAgent            = osBrowser();
        $driverLogin->driver_id = $driver->id;
        $driverLogin->user_ip   = $ip;

        $driverLogin->browser = @$driverAgent['browser'];
        $driverLogin->os      = @$driverAgent['os_platform'];
        $driverLogin->save();

        $driver = Driver::find($driver->id);

        return $driver;
    }
}
