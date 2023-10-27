<?php
use App\Models\Cart;
use App\Models\Wishlist;

function totalCartItems() {
  if (Auth::check()) {
    $user_id = Auth::user()->id;
    $totalCartItems = Cart::where('user_id', $user_id)->sum('quantity');
  } else {
    $session_id = Session::get('session_id');
    $totalCartItems = Cart::where('session_id', $session_id)->sum('quantity');
  }
  return $totalCartItems;
}

function totalWishlistItems() {
  if (Auth::check()) {
      //User is Logged in / pick auth id of the User
      $user_id = Auth::user()->id;
      $totalWishlistItems = Wishlist::where('user_id', $user_id)->count();
  }

  return $totalWishlistItems;
}