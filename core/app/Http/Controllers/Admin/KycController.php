<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Lib\FormProcessor;
use Illuminate\Http\Request;

class KycController extends Controller
{

    public function driverVerification()
    {
        $pageTitle = 'Driver Verification Form';
        $form      = Form::where('act', 'driver_verification')->first();
        return view('admin.kyc.driver_verification', compact('pageTitle', 'form'));
    }

    public function driverVerificationUpdate(Request $request)
    {

        $formProcessor       = new FormProcessor();
        $generatorValidation = $formProcessor->generatorValidation();
        $request->validate($generatorValidation['rules'], $generatorValidation['messages']);
        $exist = Form::where('act', 'driver_verification')->first();
        $formProcessor->generate('driver_verification', $exist, 'act');

        $notify[] = ['success', 'Driver verification data updated successfully'];
        return back()->withNotify($notify);
    }

    public function vehicleVerification()
    {
        $pageTitle = 'Vehicle Verification Form';
        $form      = Form::where('act', 'vehicle_verification')->first();
        return view('admin.kyc.vehicle_verification', compact('pageTitle', 'form'));
    }

    public function vehicleVerificationUpdate(Request $request)
    {
        $formProcessor       = new FormProcessor();
        $generatorValidation = $formProcessor->generatorValidation();
        $request->validate($generatorValidation['rules'], $generatorValidation['messages']);
        $exist = Form::where('act', 'vehicle_verification')->first();
        $formProcessor->generate('vehicle_verification', $exist, 'act');

        $notify[] = ['success', 'vehicle verification data updated successfully'];
        return back()->withNotify($notify);
    }
}
