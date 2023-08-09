<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use Session;

class CmsController extends Controller
{
    public function cmspages() {
        Session::put('page', "cmspages");
        $cms_pages = CmsPage::get();
        //dd($cms_pages);
        return view('admin.pages.cms_pages')->with(compact('cms_pages'));
    }

    public function updateCMSPageStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update brands table
            CmsPage::where('id', $data['page_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'page_id'=>$data['page_id']]);
        }
    }

    public function addEditCmsPage(Request $request, $id = null) {
        Session::put('page', 'cmspages');
        if ($id == null) {
            $title = "Add CMS Page";
            $cmspage = new CmsPage;
            $message = "CMS Page added successfully";
        } else {
            $title = "Edit CMS Page";
            $cmspage = CmsPage::find($id);
            $message = "CMS Page updated successfully";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            
            $rules = [
                'title' => 'required',
                'url' => 'required',
                'description' => 'required'
            ];

            $customMessage =[
                'title.required' => 'Title is required',
                'url.required' => 'URL is required',
                'description.required' => 'Description is required'
            ];

            $this->validate($request, $rules, $customMessage);

            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            $cmspage->meta_title = $data['meta_title'];
            $cmspage->meta_description = $data['meta_description'];
            $cmspage->meta_keywords = $data['meta_keywords'];
            $cmspage->status = 1;
            $cmspage->save();
            //echo "<pre>"; print_r($cmspage->title); die;
            Session::put('success_message', $message);
            return redirect('/admin/cms-pages');
        }

        return view('admin.pages.add_edit_cmspage')->with(compact('title', 'message', 'cmspage'));
    }

    public function deleteCMSPage($id) {
        //Delete Page
        CmsPage::where('id', $id)->delete();
        $message = "Page has been deleted successfully";
        Session::put('success_message', $message);
        return redirect()->back();
    }
}
