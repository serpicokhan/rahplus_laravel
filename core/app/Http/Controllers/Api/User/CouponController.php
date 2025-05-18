<?php

namespace App\Http\Controllers\Api\User;

use App\Constants\Status;
use App\Models\Ride;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function coupons()
    {
        $coupons  = Coupon::active()->orderBy('id','desc')->get();
        $notify[] = 'Coupon code';
        return apiResponse('coupon', 'success', $notify, $coupons);
    }

    public function applyCoupon(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return apiResponse('validation_error', 'error', $validator->errors()->all());
        }

        $coupon = Coupon::active()->where('code', $request->coupon_code)->first();

        if (!$coupon) {
            $notify[] = 'The coupon is not found';
            return apiResponse('not_found', 'error', $notify);
        }

        $ride  = Ride::where('status', Status::RIDE_END)->where('user_id', auth()->id())->find($id);
        if (!$ride) {
            $notify[] = 'The ride is not found';
            return apiResponse('not_found', 'error', $notify);
        }

        
        $couponUsingTime = Ride::where('applied_coupon_id', $coupon->id)->where('user_id', $ride->user_id)->whereIn('status', [Status::RIDE_COMPLETED, Status::RIDE_END])->count();

        if ($couponUsingTime != 0 && $coupon->maximum_using_time >= $couponUsingTime) {
            $notify[] = 'You are using the maximum time of this coupon.';
            return apiResponse('not_available', 'error', $notify);
        }

        $minimumAmount = $coupon->minimum_amount;
        $amount        = $ride->amount;

        if ($amount < $minimumAmount) {
            $notify[] = 'Minimum of ' . showAmount($minimumAmount) . ' will be spent on this using this coupon.';
            return apiResponse('limit', 'error', $notify);
        }

        if ($coupon->discount_type == Status::DISCOUNT_PERCENT) {
            $discountAmount = $amount / 100 * $coupon->amount;
        } else {
            $discountAmount = $coupon->amount;
        }

        $ride->applied_coupon_id = $coupon->id;
        $ride->discount_amount   = $discountAmount;
        $ride->commission_amount = ($ride->amount - $discountAmount) / 100 * $ride->commission_percentage;
        $ride->save();

        $notify[] =  'Coupon applied successfully';

        return apiResponse('coupon_applied', 'success', $notify, [
            'discount_amount' => $discountAmount,
            'coupon'          => $coupon->coupon,
        ]);
    }

    public function removeCoupon($id)
    {
        $ride  = Ride::where('user_id', auth()->id())->find($id);

        if (!$ride) {
            $notify[] = 'The ride is not found';
            return apiResponse('not_found', 'error', $notify);
        }

        if (!$ride->applied_coupon_id) {
            $notify[] = 'You have not applied the coupon for this ride';
            return apiResponse('not_available', 'error', $notify);
        }

        $ride->applied_coupon_id = 0;
        $ride->discount_amount   = 0;
        $ride->commission_amount = $ride->amount / 100 * $ride->commission_percentage;
        $ride->save();
        
        $notify[] =  'Coupon delete successfully';
        return apiResponse('coupon_delete', 'success', $notify);
    }
}
