<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\usersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Carbon\Carbon;
use Session;
use DB;

class UsersController extends Controller
{
    public function users() {
        Session::put('page', 'users');
        $users = User::get();
        return view('admin.users.users')->with(compact('users'));
    }

    public function updateUserStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update users table
            User::where('id', $data['user_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'user_id'=>$data['user_id']]);
        }
    }

    public function viewUsersCharts() {
        Session::put('page', 'users');
        $current_month_users = User::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();

        $months = array();
        $usersCount = array();
        $count = 3;
        while ($count >= 0) {
            $months[] = date('M Y', strtotime('-'.$count.' month'));
            if ($count != 0) {
                $usersCount[] = User::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->subMonth($count))
                ->count();
            }
            
            $count--;
        }
        array_push($usersCount, $current_month_users);

        $dataPoints = array();
        foreach ($months as $key => $month) {
            $dataPoints[] = array(
                "y" => $usersCount[$key], 
                "label" => $month
            );
        }

        return view('admin.users.view_users_charts')->with(compact('dataPoints'));
    }

    public function viewUsersCountries() {
        Session::put('page', 'users');
        $get_users_countries = User::select('country', DB::raw('count(country) as count'))
        ->groupBy('country')
        ->get()->toArray();
        //dd($get_users_countries);

        $dataPoints = array();
        foreach ($get_users_countries as $key => $country) {
            $dataPoints[] = array(
                "y" => $country['count'], 
                "label" => $country['country']
            );
        }

        return view('admin.users.view_users_countries')->with(compact('dataPoints'));
    }

    public function exportUsers() {
        return Excel::download(new usersExport, 'users.xlsx');
    }
}
