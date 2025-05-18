<?php

namespace App\Http\Controllers\Api\Driver\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\SocialLogin;
use App\Models\UserLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->username = $this->findusername();
    }

    public function login(Request $request)
    {

        $validator = $this->validateLogin($request);
        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $credentials = request([$this->username, 'password']);

        if (!Auth::guard('driver')->attempt(array_merge($credentials, ['is_deleted' => Status::NO]))) {
            $response[] = 'The provided credentials can not match our record';
            return apiResponse("invalid_credential", "error", $response);
        }

        $driver        = $request->user('driver');
        $tokenResult = $driver->createToken('driver_token', ['driver'])->plainTextToken;
        $this->authenticated($request, $driver);
        $response[] = 'Login Successful';

        return apiResponse("login_success", "success", $response, [
            'driver'       => $driver,
            'access_token' => $tokenResult,
            'token_type'   => 'Bearer'
        ]);
    }

    public function findusername()
    {
        $login     = request()->input('username');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function validateLogin(Request $request)
    {
        $validationRule = [
            $this->username() => 'required|string',
            'password'        => 'required|string',
        ];
        $validate = Validator::make($request->all(), $validationRule);
        return $validate;
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        $notify[] = 'Logout Successful';
        return apiResponse("logout", "success", $notify);
    }

    public function authenticated(Request $request, $driver)
    {
        $driver->tv = $driver->ts == Status::VERIFIED ? Status::UNVERIFIED : Status::VERIFIED;
        $driver->save();

        $ip        = getRealIP();
        $exist     = UserLogin::where('user_ip', $ip)->where('driver_id', $driver->id)->first();
        $driverLogin = new UserLogin();

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
    }



    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider' => 'required|in:google,apple',
            'token'    => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $socialLogin = new SocialLogin('driver',$request->provider);
        return $socialLogin->login();
    }

    protected function guard()
    {
        return Auth::guard('driver');
    }
}
