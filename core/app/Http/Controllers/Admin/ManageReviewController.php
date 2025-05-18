<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ManageReviewController extends Controller
{
    public function reviews()
    {
        $pageTitle = 'All  Reviews';
        $reviews   = Review::with(['ride', 'ride.user', 'ride.driver', 'driver'])
            ->searchable(['ride:uid', 'user:username', 'driver:username'])
            ->orderBy("id", getOrderBy())
            ->paginate(getPaginate());
        return view('admin.reviews.all', compact('pageTitle', 'reviews'));
    }
}
