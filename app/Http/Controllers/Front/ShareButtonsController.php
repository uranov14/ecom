<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShareButtonsController extends Controller
{
    public function share() {
        $data = ['id'=>1, 'title'=>'First title', 'description'=>'Social Share Buttons in Laravel', 'image'=>'apple-touch-icon-144-precomposed.png'];

        $shareButtons = \Share::page(
            url('/post'),
            "here is the text"
        )
        ->facebook()
        ->twitter()
        ->linkedin()
        ->whatsapp()
        ->pinterest()
        ->reddit()
        ->telegram();

        return view('front.post')->with(compact('data', 'shareButtons'));
    }
}
