<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Credit;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationAcceptanceMail;
use App\Models\Setting;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = User::all();
        return view('admin.pages.user-management.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status_change($id)
    {
        
        $credit = Setting::first();
        $credit_amount = $credit->monthly_credit;
        
        
        $row = User::find($id);
        
        if ($row->status == 1) {
            $row->status = 0;
        } else {
            $row->status = 1;

            $credit_data = Credit::where('user_id', $id)->first();
            if (empty($credit_data)) {
                $credit_data = New Credit;
                $credit_data->user_id = $id;
                $credit_data->total_credit_gain = $credit_amount;
                $credit_data->total_credit_left = $credit_amount;
                $credit_data->last_credit_added = $credit_amount;
                $credit_data->last_credit_added_date = date('Y-m-d h:i:s', time());
                $credit_data->save();
            }

        }
        $row->save();

        if ($row->status == 1) {
            $body = 'Your request has been accepted. You can login with username and password.';
        } else {
            $body = 'Your account has been deactivated. Contact with the administrator.';
        }
        
        $email_data = [
            'name' => $row->name,
            'body' => $body,
            'subject' => $row->status == 1 ? 'Account Approved' : 'Account Inactive',
        ];
        Mail::to($row->email)->send(new RegistrationAcceptanceMail($email_data));

        return redirect()
            ->back()
            ->with('success', 'Status Changed successfully!');
    }
}