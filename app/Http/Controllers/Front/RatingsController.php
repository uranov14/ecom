<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use Auth;
use Session;

class RatingsController extends Controller
{
    public function addRating(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (!Auth::check()) {
                //User is not Login
                $message = "Login to rate this product.";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            if (!isset($data['rating'])) {
                $message = "Add atleast one star rating for this product!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            $countRatings = Rating::where(['user_id'=>Auth::user()->id, 'product_id'=>$data['product_id'], 'status'=>1])->count();
            if ($countRatings > 0) {
                $message = "Your rating already exists for this product!";
                Session::flash('error_message', $message);
                return redirect()->back();
            } else {
                //Save rating in ratings table
                $rating = new Rating;
                $rating->user_id = Auth::user()->id;
                $rating->product_id = $data['product_id'];
                $rating->rating = $data['rating'];
                $rating->review = $data['review'];
                $rating->status = 0;
                $rating->save();

                $message = 'Thanks for rating this Product! It will been shown once approved!';
                Session::flash('success_message', $message);
                return redirect()->back();
            }
        }
    }
}
