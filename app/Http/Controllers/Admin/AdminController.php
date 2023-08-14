<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin; 
use App\Models\Section;
use App\Models\AdminRole; 
use Session;
use Auth;
use Hash;
use Image;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function dashboard() {
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    public function login(Request $request) {
        //echo $password = Hash::make('123456'); die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            /* $validated = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|min:6',
            ]); */

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|min:6',
            ];

            $customMessage = [
                'email.required' => 'Email Address is required!',
                'email.email' => 'Valid Email is required!',
                'password.required' => 'Password is required!',
                'password.min' => 'Password must be more than 6 characters.'
            ];

            $this->validate($request, $rules, $customMessage);

            auth('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']]);
            /* $userName = Auth::guard('admin')->user();
            dd($userName); */

            if (Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password'], 'status'=>1])) {
                return redirect('admin/dashboard');
            } else {
                Session::flash('error_message', 'Invalid Email or Password!');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function settings(Request $request) {
        Session::put('page', 'settings');
        // echo "<pre>"; print_r(Auth::guard('admin')->user()); die; 
        /* if($request->isMethod('POST')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            //Check if current password entrted by admin is correct
            if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                //Check if new password is matching with confirm password
                if($data['confirm_password'] == $data['new_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Password has been updated successfully!');
                }else {
                    return redirect()->back()->with('error_message', 'Your new password and confirm password does not match!');
                }
            }else {
                return redirect()->back()->with('error_message', 'Your current password is incorrect!');
            }
        } */
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function checkCurrentPassword(Request $request) {
        $data = $request->all();
        //echo "<pre>"; print_r($data); die; 
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            return true;
        }else {
            return false;
        }
    }

    public function updateCurrentPassword(Request $request) {
        Session::put('page', 'admin_settings');
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die; 
            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                if ($data['new_password'] == $data['confirm_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    Session::flash('success_message', 'Your Password has been updated successfully!');
                } else {
                    Session::flash('error_message', 'Your New Password and Confirm Password do not match!');
                }
            }else {
                Session::flash('error_message', 'Your current password is incorrect!');
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request) {
        Session::put('page', 'update_admin_details');
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image'
            ];

            $customMessage =[
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile Number is required',
                'admin_mobile.numeric' => 'Valid Mobile Number is required',
                'admin_image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rules, $customMessage);

            //Upload Admin Photo
            if($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    //Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName= rand(111, 99999).'.'.$extension;
                    
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->resize(400, 400)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            }else {
                $imageName = '';
            }
            // echo "<pre>"; print_r($imageName); die; 
            //Update Admin Details
            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'name'=>$data['admin_name'], 
                'mobile'=>$data['admin_mobile'],
                'image'=>$imageName,
            ]);
            return redirect()->back()->with('success_message', 'Admin details updated successfully');
        }
        return view('admin.update_admin_details');
    }

    public function sections() {
        Session::put('page', 'sections');
        $sections = Section::get();
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update sections table
            Section::where('id', $data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'section_id'=>$data['section_id']]);
        }
    }

    public function adminsSubadmins() {
        Session::put('page', 'admins_subadmins');

        if (Auth::guard('admin')->user()->type == "subadmin") {
            Session::flash('error_message', 'This feature is restricted!');
            return redirect('admin/dashboard');
        }

        $admins = Admin::get();
        return view('admin.admins.admins_subadmins')->with(compact('admins'));
        // dd($admins); 
    }

    public function updateAdminStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update admins table
            Admin::where('id', $data['admin_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'admin_id'=>$data['admin_id']]);
        }
    }

    public function addEditAdmin(Request $request, $id = null) {
        Session::put('page', 'admins_subadmins');
        if ($id == null) {
            $title = "Add Admin";
            $admin = new Admin;
            $message = "Admin added successfully";
        } else {
            $title = "Edit Admin";
            $admin = Admin::find($id);
            $message = "Admin updated successfully";
        }
        //echo "<pre>"; print_r($admin); die;
        if($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            if ($id == null) {
                $adminCount = Admin::where('email', $data['admin_email'])->count();
                if ($adminCount > 0) {
                    Session::flash('error_message', "Admin/Sub-Admin already exists!");
                    return redirect('admin/admins-subadmins');
                }
            } 

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image'
            ];

            $customMessage =[
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile Number is required',
                'admin_mobile.numeric' => 'Valid Mobile Number is required',
                'admin_image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rules, $customMessage);

            //Upload Admin Photo
            if($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    //Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName= rand(111, 99999).'.'.$extension;
                    
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->resize(400, 400)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            }else {
                $imageName = '';
            }
            // echo "<pre>"; print_r($imageName); die; 
            //Update Admin Details
            $admin->image = $imageName;
            $admin->name = $data['admin_name'];
            $admin->mobile = $data['admin_mobile'];
            if ($id == null) {
                $admin->email = $data['admin_email'];
                $admin->type = $data['admin_type'];
            }
            if ($data['admin_password'] != "") {
                $admin->password = bcrypt($data['admin_password']);
            }
            $admin->save();
            Session::flash('success_message', $message); 
            return redirect('admin/admins-subadmins');
        }

        return view('admin.admins.add_edit_admin')->with(compact('title', 'admin'));
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function deleteAdmin($id) {
        //Delete Admin from admins table
        Admin::where('id', $id)->delete();

        $message = 'Admin has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function updateRole(Request $request, $id) {
        Session::put('page', 'admins_subadmins');
        if($request->isMethod('post')) {
            $data = $request->all();
            unset($data['_token']);
            //echo "<pre>"; print_r($data); die;

            AdminRole::where('admin_id', $id)->delete();
            foreach ($data as $key => $value) {
                if (isset($value['view'])) {
                    $view = $value['view'];
                } else {
                    $view = 0;
                }
                if (isset($value['edit'])) {
                    $edit = $value['edit'];
                } else {
                    $edit = 0;
                }
                if (isset($value['full'])) {
                    $full = $value['full'];
                } else {
                    $full = 0;
                }

                AdminRole::where('admin_id', $id)->insert(['admin_id'=>$id, 'module'=>$key, 'view_access'=>$view, 'edit_access'=>$edit, 'full_access'=>$full]);
            }
            $message = "Roles updated successfully!";
            Session::flash('success_message', $message);
            return redirect()->back();
        }
        $adminDetails = Admin::where('id', $id)->first()->toArray();
        $adminRoles = AdminRole::where('admin_id', $id)->get()->toArray();
        $title = "Update ".$adminDetails['name']." (".$adminDetails['type'].") Roles/Permissions";
        return view('admin.admins.update_role')->with(compact('adminDetails', 'adminRoles', 'title'));
    }
}
