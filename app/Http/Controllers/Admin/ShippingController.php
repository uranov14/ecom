<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingCharge;
use Session;

class ShippingController extends Controller
{
    public function viewShippingCharges() {
        Session::put('page', 'shipping_charges');
        $shippingCharges = ShippingCharge::get()->toArray();
        //dd($shippingCharges);
        return view('admin.shipping.view_shipping_charges')->with(compact('shippingCharges'));
    }

    public function editShippingCharges(Request $request, $id) {
        Session::put('page', 'shipping_charges');
        $shippingDetails = ShippingCharge::where('id', $id)->first()->toArray();
        //dd($shippingDetails);
        if ($request->isMethod('post')) {
            $data = $request->all();
            ShippingCharge::where('id', $id)->update(['0_500g'=>$data['0_500g'], '501_1000g'=>$data['501_1000g'], '1001_2000g'=>$data['1001_2000g'], '2001_5000g'=>$data['2001_5000g'], 'above_5000g'=>$data['above_5000g']]);
            $message = 'Shipping Charges updated successfully!';
            Session::flash('success_message', $message);
            return redirect()->back();
        }
        return view('admin.shipping.edit_shipping_charges')->with(compact('shippingDetails'));
    }

    public function updateShippingStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update shipping_charges table
            ShippingCharge::where('id', $data['shipping_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'shipping_id'=>$data['shipping_id']]);
        }
    }
}
