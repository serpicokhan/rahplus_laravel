<?php

namespace App\Http\Controllers\Api\Driver;

use App\Models\Ride;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function review()
    {
        $driver   = auth()->user();
        $notify[] = 'Driver review list';
        return apiResponse("review", "success", $notify, [
            'user_image_path'   => getFilePath('user'),
            'driver_image_path' => getFilePath('driver'),
            "reviews"           => Review::latest('id')->where('driver_id', $driver->id)->with('ride.user')->get(),
            'driver'            => $driver->load('vehicle')
        ]);
    }

    public function riderReview($riderId)
    {
        $rider = User::active()->where('id', $riderId)->first();
        if (!$riderId) {
            $notify[] = "The rider is not found";
            return apiResponse('not_found', "error", $notify);
        }
        $notify[] = 'Rider review list';
        return apiResponse("review", "success", $notify, [
            'user_image_path'   => getFilePath('user'),
            'driver_image_path' => getFilePath('driver'),
            "reviews"           => Review::latest('id')->where('user_id', $riderId)->with('driver.vehicle','driver.vehicle.model','driver.vehicle.color','driver.vehicle.year')->get(),
            'rider'             => $rider
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

        $driver = auth()->user();
        $ride   = Ride::completed()->where('driver_id', $driver->id)->find($id);

        if (!$ride) {
            $notify[] = 'Your ride is invalid';
            return apiResponse("invalid", "error", $notify);
        }

        $existsReview = Review::where('user_id', $ride->user_id)->where('ride_id', $ride->id)->exists();

        if ($existsReview) {
            $notify[] = 'You\'ve already submitted a review & rating for this ride';
            return apiResponse('already_reviewed', 'error', $notify);
        }

        $reviewRating            = new Review();
        $reviewRating->ride_id   = $ride->id;
        $reviewRating->user_id   = $ride->user_id;
        $reviewRating->driver_id = 0;
        $reviewRating->rating    = $request->rating;
        $reviewRating->review    = $request->review;
        $reviewRating->save();

        $user       = $ride->user;
        $userReview = Review::where('user_id', $ride->user_id)->get();


        $user->avg_rating    = $userReview->avg('rating');
        $user->total_reviews = $userReview->count();
        $user->save();

        $notify[] = 'Review placed successfully';
        return apiResponse("success", 'success', $notify);
    }
}
