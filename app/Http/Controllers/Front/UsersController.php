<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Sms;
use Validator;
use Session;
use Auth;
use Hash;

class UsersController extends Controller
{
    public function loginRegister() {
        return view('front.users.login_register');
    }

    public function registerUser(Request $request) {
        if ($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $userCount = User::where('email', $data['email'])->count();
            if ($userCount > 0) {
                $message = "Email already exists!";
                Session::flash('error_message', $message);
                return redirect()->back();
            } else {
                //Insert User to users table
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                //Send Confirmation Email
                $email = $data['email'];
                $messageData = [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'code' => base64_encode($data['email'])
                ];

                Mail::send('emails.confirmation', $messageData, function ($message)use($email) {
                    $message->to($email)->subject('Confirm your E-commerce Account!');
                });

                //Redirect back user with success message
                $message = "Please confirm your email to activate your account.";
                Session::flash('success_message', $message);
                return redirect()->back();

                /* if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    //echo "<pre>"; print_r(Auth::user()); die;
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    //Send Register Sms
                    /* $message = "Dear Customer, you have been successfully registered with our E-commerce Shop. Login to your Account to access orders,addresses and available offers!";
                    $mobile = $data['mobile'];

                    Sms::sendSms($message, $mobile); */

                    //Send Register Email
                    /* $email = $data['email'];
                    $messageData = [
                        'email' => $data['email'],
                        'name' => $data['name'],
                        'mobile' => $data['mobile']
                    ];

                    Mail::send('emails.register', $messageData, function ($message)use($email) {
                        $message->to($email)->subject('Welcome to Stack Developers E-commerce!');
                    });

                    Session::flash('success_message', 'Welcome to Stack Developers E-commerce!');
                    return redirect('/cart');
                } */
            }
            
        }
    }

    public function confirmAccount($code) {
        Session::forget('error_message');
        Session::forget('success_message');

        $email = base64_decode($code);
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            $userDetails = User::where('email', $email)->first();
            //echo $userDetails->status; die;
            if ($userDetails->status == 1) {
                //Redirect the user to Login/Register Page with error message
                $message = "Your account is already activated. You can login and buy now.";
                Session::flash('error_message', $message);
                return redirect('login-register');
            } else {
                User::where('email', $email)->update(['status'=>1]);

                //Send Welcome Email
                $messageData = [
                    'email' => $email,
                    'name' => $userDetails->name,
                    'mobile' => $userDetails->mobile
                ];

                Mail::send('emails.register', $messageData, function ($message)use($email) {
                    $message->to($email)->subject('Welcome to E-commerce Website!');
                });

                //Redirect the user to Login/Register Page with success message
                $message = "Your account is activated. You can login and buy now.";
                Session::flash('success_message', $message);
                return redirect('login-register');
            }
        } else {
            abort(404);
        }
    }

    public function checkEmail(Request $request) {
        $data = $request->all();
        //Email is Available or Not
        $emailCount = User::where('email', $data['email'])->count();

        if ($emailCount > 0) {
        return "false";
        } else {
        return "true"; die;
        }
    }

    public function loginUser(Request $request) {
        if ($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                //echo "<pre>"; print_r(Session::get('session_id')); die;

                //Check Email is activated or not
                $userStatus = User::where('email', $data['email'])->first();
                if ($userStatus->status == 0) {
                    Auth::logout();
                    $message = "Your Account is not activated yet. Please confirm your email to activate!";
                    Session::flash('error_message', $message);
                    return redirect()->back();
                }
                //Update User Cart with user id
                if (!empty(Session::get('session_id'))) {
                    //echo "<pre>"; print_r(Session::get('session_id')); die;
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    
                    Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                }
                return redirect('/cart');
            } else {
                $message = "Invalid Email or Password!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }

    public function logoutUser() {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function forgotPassword(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $emailCount = User::where('email', $data['email'])->count();

            if ($emailCount == 0) {
                $message = "Email does not exists!";
                Session::flash('error_message', $message);
                Session::forget('success_message');
                return redirect()->back();
            }

            $email = $data['email'];

            //Generate New Password
            $random_password = str_random(8);

            //Encode/Secure Password
            $new_password = bcrypt($random_password);
            //Update Password
            User::where('email', $email)->update(['password'=>$new_password]);

            //Get User Name
            $userDetails = User::select('name')->where('email', $email)->first()->toArray();

            //Send Email to User
            $messageData = [
                'email' => $email,
                'name' => $userDetails['name'],
                'password' => $random_password
            ];

            Mail::send('emails.forgot_password', $messageData, function ($message)use($email) {
                $message->to($email)->subject('New Password E-commerce Account');
            });

            //Redirect to Login/Register Page with success message
            $message = "Please check your Email for new Password!";
            Session::flash('success_message', $message);
            Session::forget('error_message');

            return redirect('login-register');
            
        }
        return view('front.users.forgot_password');
    }

    public function account(Request $request) {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();
        $countries = Country::where('status', 1)->get()->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();
            Session::forget('error_message');
            Session::forget('success_message');
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric',
            ];

            $customMessage =[
                'name.required' => 'Name is required',
                'name.regex' => 'Valid Name is required',
                'mobile.required' => 'Mobile Number is required',
                'mobile.numeric' => 'Valid Mobile Number is required',
            ];

            $this->validate($request, $rules, $customMessage);

            //Update User Details
            User::where('id', $user_id)->update([
                'name'=>$data['name'],
                'mobile'=>$data['mobile'],
                'city'=>$data['city'],
                'state'=>$data['state'],
                'address'=>$data['address'],
                'country'=>$data['country'],
                'pincode'=>$data['pincode'],
            ]);

            //Redirect back user with success message
            $message = "Your Account Details has been updated successfully!";
            Session::flash('success_message', $message);
            
            return redirect()->back();

        }
            
        return view('front.users.account')->with(compact('userDetails', 'countries'));
        
    }

    public function checkUserPwd(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::user()->id;
            $currentPwd = User::select('password')->where('id', $user_id)->first();
            if (Hash::check($data['current_pwd'], $currentPwd->password)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function updateUserPwd(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::user()->id;
            $currentPwd = User::select('password')->where('id', $user_id)->first();
            if (Hash::check($data['current_pwd'], $currentPwd->password)) {
                //Update Current Password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id', $user_id)->update(['password'=>$new_pwd]);

                $message = "Your Password has been updated successfully!";
                Session::flash('success_message', $message);
                Session::forget('error_message');
                return redirect()->back();
            } else {
                $message = "Current Password is Incorrect!";
                Session::flash('error_message', $message);
                Session::forget('success_message');
                return redirect()->back();
            }
        }
    }
}
