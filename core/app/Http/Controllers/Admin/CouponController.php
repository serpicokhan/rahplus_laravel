<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index()
    {
        $pageTitle = "All Coupons";
        $coupons   = Coupon::withCount('rides')->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.coupon.index', compact('pageTitle', 'coupons'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'coupon_name'        => 'required|string|max:40',
            'coupon_code'        => 'required|string|max:40|unique:coupons,code,' . $id,
            'minimum_amount'     => 'required|numeric|gt:0',
            'discount_type'      => 'required|in:' . Status::DISCOUNT_PERCENT . "," . Status::DISCOUNT_FIXED,
            'amount'             => 'required|numeric|gt:0',
            'start_from'         => 'required|date',
            'maximum_using_time' => 'required|integer|gte:1',
            'end_at'             => 'required|date|after_or_equal:start_from',
            'description'        => 'nullable|string|max:500',
        ]);

        if ($id) {
            $coupon       = Coupon::findOrFail($id);
            $notification = 'Coupon updated successfully';
        } else {
            $coupon       = new Coupon();
            $notification = 'Coupon added successfully';
        }

        $coupon->name               = $request->coupon_name;
        $coupon->code               = $request->coupon_code;
        $coupon->start_from         = $request->start_from;
        $coupon->end_at             = $request->end_at;
        $coupon->minimum_amount     = $request->minimum_amount;
        $coupon->discount_type      = $request->discount_type;
        $coupon->amount             = $request->amount;
        $coupon->description        = $request->description;
        $coupon->maximum_using_time = $request->maximum_using_time;
        $coupon->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }


    public function changeStatus($id)
    {
        return Coupon::changeStatus($id);
    }

    public function detail($id)
    {
        $coupon    = Coupon::find($id);
        $pageTitle = 'Applied Coupons Details - ' . $coupon->coupon_name;
        $query     = AppliedCoupon::where('coupon_id', $id);

        $querySum    = clone $query;
        $totalAmount = $querySum->sum('amount');

        $queryCount  = clone $query;
        $couponCount = $querySum->count();

        $queryAppliedCoupon = clone $query;
        $appliedCoupons     = $queryAppliedCoupon->with(['user', 'ride'])->where('coupon_id', $id)->paginate(getPaginate());

        return view('admin.coupon.detail', compact('pageTitle', 'appliedCoupons', 'totalAmount', 'couponCount'));
    }
}
