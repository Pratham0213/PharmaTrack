<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\websiteLogoModel;
;
use Str;
use File;
use Auth;

class WebsiteLogoController extends Controller
{
    public function website_logo(Request $request)
    {
        // echo 'hjvjhv '; die();
        $data['getRecord'] = websiteLogoModel::find(1);
        return view('admin.website_logo.update', $data);
    }

    public function website_logo_update(Request $request)
    {
        $save = websiteLogoModel::find(1);
        $save->website_name = trim($request->website_name);

        if (!empty($request->file('logo'))) {

            //old image remove start
            if (!empty($save->logo) && file_exists('upload/logo/' . $save->logo)) {
                unlink('upload/logo/' . $save->logo);
            }
            //old image remove end



            $file = $request->file('logo');
            $randomStr = Str::random(30);
            $filename = $randomStr . '.' . $file->getClientOriginalExtension();
            $file->move('upload/logo/', $filename);
            $save->logo = $filename;

        }

        $save->save();

        return redirect('admin/website_logo')->with('success', 'Website Logo saved successfully');

    }
}