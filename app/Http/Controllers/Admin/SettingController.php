<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact_us;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set("Europe/London");

class SettingController extends Controller
{
    public function setting()
    {
        $row = Setting::where('id', 1)->first();
        return view('admin.pages.settings.settings', compact('row'));
    }

    public function system_update(Request $request)
    {
        $this->validate($request,[
            'project_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'monthly_credit' => 'required'
        ]);

        DB::beginTransaction(); //transaction start
        $info = Setting::where('id', 1)->first();
        $info->project_name = $request->project_name;
        $info->email = $request->email;
        $info->phone = $request->phone;
        $info->address = $request->address;
        $info->monthly_credit = $request->monthly_credit;
        $info->save();
        DB::commit(); //transaction end

        return redirect()->back()->with('success', 'Data Updated successfully');
    }
}