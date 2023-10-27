<?php

namespace App\Http\Controllers\Admin;

use App\Exports\subscribersExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use Session;

class NewsletterController extends Controller
{
    public function subscribers() {
        Session::put('page', 'newsletter_subscribers');
        $subscribers = NewsletterSubscriber::get()->toArray();

        return view('admin.subscribers.subscribers')->with(compact('subscribers'));
    }

    public function updateSubscriberStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update newsletter_subscribera table
            NewsletterSubscriber::where('id', $data['subscriber_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'subscriber_id'=>$data['subscriber_id']]);
        }
    }

    public function deleteSubscriber($id) {
        NewsletterSubscriber::where('id', $id)->delete();
        $message = "Subscriber has been deleted successfully";
        Session::put('success_message', $message);
        return redirect()->back();
    }

    public function exportSubscribers() {
        return Excel::download(new subscribersExport, 'subscribers.xlsx');
    }
}
