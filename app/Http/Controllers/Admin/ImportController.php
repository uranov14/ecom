<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class ImportController extends Controller
{
    public function updateCODPincodes(Request $request) {
        Session::put('page', 'update_cod_pincodes');
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Upload Pincodes CSV to pincodes folder
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $destination = public_path('imports/pincodes');
                $ext = $file->getClientOriginalExtension();
                $fileName = "pincodes-".rand().".".$ext;
                $file->move($destination, $fileName);
            }

            $file = public_path('imports/pincodes/'.$fileName);
            $pincodes = $this->csvToArray($file); // convert data to array
            //echo "<pre>"; print_r($pincodes); die;
            $latestPincodes = array();
            foreach ($pincodes as $key => $pincode) {
                $latestPincodes[$key]['pincode'] = $pincode['pincode'];
                $latestPincodes[$key]['created_at'] = date('Y-m-d H:i:s');
                $latestPincodes[$key]['updated_at'] = date('Y-m-d H:i:s');
            }

            DB::table('cod_pincodes')->delete();
            DB::update("Alter Table cod_pincodes AUTO_INCREMENT=1;");
            DB::table('cod_pincodes')->insert($latestPincodes);

            $message = "COD Pincodes nave been updated Successfully!";
            Session::flash('success_message', $message);

            return redirect()->back();
        }
        return view('admin.pincodes.update_cod_pincodes');
    }

    public function updatePrepaidPincodes(Request $request) {
        Session::put('page', 'update_prepaid_pincodes');
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Upload Pincodes CSV to pincodes folder
            if ($request->hasFile('file')) {
                //echo "<pre>"; print_r($data); die;
                if ($request->file('file')->isValid()) {
                    $file = $request->file('file');
                    $destination = public_path('imports/pincodes');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = "pincodes-".rand().".".$ext;
                    $file->move($destination, $fileName);
                }
            }

            $file = public_path('imports/pincodes/'.$fileName);
            $pincodes = $this->csvToArray($file); // convert data to array
            //echo "<pre>"; print_r($pincodes); die;
            $latestPincodes = array();
            foreach ($pincodes as $key => $pincode) {
                $latestPincodes[$key]['pincode'] = $pincode['pincode'];
                $latestPincodes[$key]['created_at'] = date('Y-m-d H:i:s');
                $latestPincodes[$key]['updated_at'] = date('Y-m-d H:i:s');
            }

            DB::table('prepaid_pincodes')->delete();
            DB::update("Alter Table prepaid_pincodes AUTO_INCREMENT=1;");
            DB::table('prepaid_pincodes')->insert($latestPincodes);

            $message = "Prepaid Pincodes nave been updated Successfully!";
            Session::flash('success_message', $message);

            return redirect()->back();
        }
        return view('admin.pincodes.update_prepaid_pincodes');
    }

    public function csvToArray($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return false;
            $header = null;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
        return $data;
    }
}
