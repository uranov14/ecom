<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use App\Models\Admin;
use Validator;
use Session;

class CmsController extends Controller
{
    public function cmsPage(Request $request) {
        /* $currentRoute = url()->current();
        $currentRoute = str_replace("http://127.0.0.1:8000/", "", $currentRoute); */
        $currentRoute = Route::getFacadeRoot()->current()->uri();
        /* echo $currentRoute; die; */
        $cmsUrls = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();

        if (in_array($currentRoute, $cmsUrls)) {
            $cmsPageDetails = CmsPage::where('url', $currentRoute)->first()->toArray();
            $meta_title = $cmsPageDetails['meta_title'];
            $meta_description = $cmsPageDetails['meta_description'];
            $meta_keywords = $cmsPageDetails['meta_keywords'];

            return view('front.pages.cms_page')->with(compact('cmsPageDetails', 'meta_title', 'meta_description', 'meta_keywords'));

        } else {
            abort(404);
        }
    }

    public function contact(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email|max:150',
                'subject' => 'required|max:200',
                'message' => 'required'
            ];

            $customMessage =[
                'name.required' => 'Name is required',
                'name.regex' => 'Valid Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'subject.required' => 'Subject is required',
                'message.required' => 'Message is required'
            ];

            $validator = Validator::make($data, $rules, $customMessage);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //Send User query to Admin
            $admin_email = Admin::select('email')->where('id', 1)->first()->toArray();
            //echo "<pre>"; print_r($admin_email['email']); die;
            $email = $admin_email['email'];
            $messageData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'comment' => $data['message']
            ];

            Mail::send('emails.enquiry', $messageData, function ($message)use($email) {
                $message->to($email)->subject('Enquiry from the Ukrainian Sector from a User.');
            });

            $message = "Thanks for your query. We will get back to you soon.";
            Session::flash('success_message', $message);
            return redirect()->back();
        }
        return view('front.pages.contact');
    }
}
