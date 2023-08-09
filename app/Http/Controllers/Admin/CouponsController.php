<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Section;
use App\Models\User;
use App\Models\AdminRole;
use Auth;
use Session;

class CouponsController extends Controller
{
    public function coupons() {
        Session::put('page', 'coupons');
        $coupons = Coupon::get()->toArray();

        // Set Admin/Sub-Admin Permissions for Coupons
        $moduleCouponsCount = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'coupons'])->count();
        if (Auth::guard('admin')->user()->type == "superadmin") {
            $moduleCoupons['view_access'] = 1;
            $moduleCoupons['edit_access'] = 1;
            $moduleCoupons['full_access'] = 1;
        } else if ($moduleCouponsCount == 0) {
            $message = "This feature is restricted for you!";
            Session::flash('error_message', $message);
            return redirect('admin/dashboard');
        } else {
            $moduleCoupons = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'coupons'])->first()->toArray();
        }

        return view('admin.coupons.coupons')->with(compact('coupons', 'moduleCoupons'));
    }

    public function updateCouponStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update coupons table
            Coupon::where('id', $data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'coupon_id'=>$data['coupon_id']]);
        }
    }

    public function addEditCoupon(Request $request, $id = null) {
        Session::put('page', 'coupons');
        if ($id == null) {
            $title = "Add Coupon";
            $selectCats = array();
            $selectUsers = array();
            $coupon = new Coupon;
            $message = "added successfully";
        } else {
            $title = "Edit Coupon";
            $coupon = Coupon::find($id);
            $selectCats = explode(',', $coupon['categories']);
            $selectUsers = explode(',', $coupon['users']);
            $message = "updated successfully";
        }
        
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required|numeric',
                'categories' => 'required',
                'expiry_date' => 'required',
            ];

            $customMessage =[
                'coupon_option.required' => 'Select Coupon Option',
                'coupon_type.required' => 'Select Coupon Type',
                'amount_type.required' => 'Select Amount Type',
                'amount.required' => 'Amount is required',
                'amount.numeric' => 'Valid Amount is required',
                'categories.required' => 'Select Categories',
                'expiry_date.required' => 'Expiry Date is required',
            ];

            $this->validate($request, $rules, $customMessage);

            if (isset($data['users'])) {
                $users = implode(',', $data['users']);
            } else {
                $users = "";
            }
            if (isset($data['categories'])) {
                $categories = implode(',', $data['categories']);
            }
            if ($data['coupon_option'] == "Automatic") {
                $coupon_code = str_random(8);
            } else {
                $coupon_code = $data['coupon_code'];
            }
            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1;
            
            $coupon->save();
            
            Session::flash('success_message', "Coupon ".$data['coupon_code']." ".$message);
            return redirect('admin/coupons');
        }

        //Get All Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        //Get Users Email
        $users = User::select('email')->where('status', 1)->get()->toArray();
        
        return view('admin.coupons.add_edit_coupon')->with(compact('title', 'coupon', 'categories', 'users', 'selectCats', 'selectUsers'));
    }

    public function deleteCoupon($id) {
        //Delete Coupon from coupons table
        Coupon::where('id', $id)->delete();

        $message = 'Coupon has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }
}
