<?php

namespace App\Http\Controllers\Api\Driver\Auth;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function sendResetCodeEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $fieldType = $this->findFieldType();
        $driver    = Driver::where($fieldType, $request->value)->first();

        if (!$driver) {
            $notify[] = 'The account could not be found';
            return apiResponse("user_not_found", "error", $notify);
        }

        PasswordReset::where('email', $driver->email)->delete();

        $code                 = verificationCode(6);
        $password             = new PasswordReset();
        $password->email      = $driver->email;
        $password->token      = $code;
        $password->created_at = Carbon::now();
        $password->save();

        $driverIpInfo      = getIpInfo();
        $driverBrowserInfo = osBrowser();

        notify($driver, 'PASS_RESET_CODE', [
            'code'             => $code,
            'operating_system' => @$driverBrowserInfo['os_platform'],
            'browser'          => @$driverBrowserInfo['browser'],
            'ip'               => @$driverIpInfo['ip'],
            'time'             => @$driverIpInfo['time']
        ], ['email']);

        $email      = $driver->email;
        $response[] = 'Verification code sent to mail';
        return apiResponse("code_sent", "success", $response, [
            'email' => $email
        ]);
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'  => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $code = $request->code;
        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = 'Verification code doesn\'t match';
            return apiResponse("code_not_match", "error", $notify);
        }
        $response[] = 'You can change your password.';
        return apiResponse("success", "success", $response);
    }

    public function reset(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }
        $reset = PasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        if (!$reset) {
            $response[] = 'Invalid verification code';
            return apiResponse("invalid_code", "error", $response);
        }

        $driver           = Driver::where('email', $reset->email)->first();
        $driver->password = Hash::make($request->password);
        $driver->save();

        $driverIpInfo  = getIpInfo();
        $driverBrowser = osBrowser();

        notify($driver, 'PASS_RESET_DONE', [
            'operating_system' => @$driverBrowser['os_platform'],
            'browser'          => @$driverBrowser['browser'],
            'ip'               => @$driverIpInfo['ip'],
            'time'             => @$driverIpInfo['time']
        ], ['email']);

        $response[] = 'Password changed successfully';
        return apiResponse("password_changed", "success", $response);
    }

    protected function rules()
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => ['required', 'confirmed', $passwordValidation],
        ];
    }

    private function findFieldType()
    {
        $input = request()->input('value');

        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $input]);
        return $fieldType;
    }
}
