<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Sms;
use Illuminate\Support\Facades\Mail; 
use Session;
use Auth;

class PaypalController extends Controller
{
    public function paypal() {
        if (Session::has('order_id')) {
            $orderDetails = Order::where('id', Session::get('order_id'))->first()->toArray();
            $nameArr = explode(" ", $orderDetails['name']);
            return view('front.paypal.paypal')->with(compact('orderDetails', 'nameArr'));
        } else {
            return redirect('cart');
        }
        /* $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => round(Session::get('grand_total'), 2)
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('paypal')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        } */
    }

    public function success() {
        if (Session::has('order_id')) {
            //Empty the Cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.paypal.success');
        } else {
            return redirect('cart');
        }
        /* $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('create.payment')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
        Cart::where('user_id', Auth::user()->id)->delete(); */
    }

    public function fail() {
        return view('front.paypal.fail');
        /* return redirect()
            ->route('create.payment')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.'); */
    }

    public function ipn(Request $request) {
        $data = $request->all();
        //$data['payment_status'] = 'Completed';
        if ($data['payment_status'] == 'Completed') {
            // Process the order
            $order_id = Session::get('order_id');

            // Update Order Status to Paid
            Order::where('id', $order_id)->update(['order_status' => "Paid"]);

            //Send Order SMS
            $message = "Dear Customer, your order ".$order_id."has been successfully placed! We will intimate you once your order is shipped.";
            $mobile = Auth::user()->mobile;

            Sms::sendSms($message, $mobile);

            $orderDetails = Order::with('order_products')->where('id', $order_id)->first()->toArray();

            //Send Order Email
            $email = Auth::user()->email;
            $messageData = [
                'email' => $email,
                'name' => Auth::user()->name,
                'order_id' => $order_id,
                'orderDetails' => $orderDetails
            ];
            Mail::send('emails.order', $messageData, function ($message)use($email) {
                $message->to($email)->subject('Order Placed - Your Shop!');
            });

        } else {
            # code...
        }
        
        //return view('front.paypal.fail');
    }
}
