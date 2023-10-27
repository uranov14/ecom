<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function addSubscriber(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $subscriberCount = NewsletterSubscriber::where('email', $data['subscriber_email'])->count();
            if ($subscriberCount > 0) {
                return 'exists';
            } else {
                // Add Newsletter Subscriber Email in newsletter_subscribers table
                $subscriber = new NewsletterSubscriber;
                $subscriber->email = $data['subscriber_email'];
                $subscriber->email = $data['subscriber_email'];
                $subscriber->save();
                return 'inserted';
            }
            
        }
    }
}
