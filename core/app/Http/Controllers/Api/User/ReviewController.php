<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Ride;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function review()
    {
        $user     = auth()->user();
        $notify[] = 'Rider review list';
        return apiResponse("review", "success", $notify, [
            'user_image_path'   => getFilePath('user'),
            'driver_image_path' => getFilePath('driver'),
            "reviews"           => Review::latest('id')->where('user_id', $user->id)->with('ride.driver')->get(),
            'rider'             => $user
        ]);
    }

    public function driverReview($driverId)
    {
        $driver = Driver::active()->where('id', $driverId)->with('vehicle')->first();

        if (!$driver) {
            $notify[] = "The driver is not found";
            return apiResponse('not_found', "error", $notify);
        }

        $notify[] = 'Driver review list';
        return apiResponse("review", "success", $notify, [
            'user_image_path'   => getFilePath('user'),
            'driver_image_path' => getFilePath('driver'),
            "reviews"           => Review::latest('id')->where('driver_id', $driver->id)->with('ride', 'ride.user')->get(),
            'driver'            => $driver
        ]);
    }

    public function reviewStore(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'rating' => 'required|in:1,2,3,4,5',
        ]);

        if ($validator->fails()) {
            return apiResponse('validation_error', 'error', $validator->errors()->all());
        }

        $user = auth()->user();
        $ride = Ride::completed()->where('user_id', $user->id)->find($id);

        if (!$ride) {
            $notify[] = 'Your ride is invalid';
            return apiResponse("invalid", "error", $notify);
        }

        $driver       = $ride->driver;
        $existsReview = Review::where('driver_id', $driver->id)->where('ride_id', $ride->id)->exists();

        if ($existsReview) {
            $notify[] = 'You\'ve already submitted a review & rating for this ride';
            return apiResponse('already_reviewed', 'error', $notify);
        }

        $reviewRating            = new Review();
        $reviewRating->ride_id   = $ride->id;
        $reviewRating->user_id   = 0;
        $reviewRating->driver_id = $ride->driver_id;
        $reviewRating->rating    = $request->rating;
        $reviewRating->review    = $request->review;
        $reviewRating->save();

        $driverReview          = Review::where('driver_id', $ride->driver_id)->get();
        $driver->avg_rating    = $driverReview->avg('rating');
        $driver->total_reviews = $driverReview->count();
        $driver->save();

        $notify[] = 'Review placed successfully';
        return apiResponse("success", 'success', $notify);
    }
}
