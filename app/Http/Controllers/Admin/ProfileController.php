<?php

namespace App\Http\Controllers\Admin;

use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use File;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $admin = Admin::find(Auth::user()->id);
        return view('admin.pages.profile.edit', compact('admin'));
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
        $validated = $request->validate([
            'avatar' => 'nullable|file|image',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($id)],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],

        ]);

        $avatar = $request->old_avatar;
        if (request()->hasFile('avatar')) {
            //old image delete after updating
            if(File::exists('storage/'.$request->old_avatar)) {
                if($request->old_avatar){
                    unlink('storage/'.$request->old_avatar);
                }
            }
            // Get filename with the extension
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filenameWithExt = str_replace(' ', '', $filenameWithExt);
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('avatar')->getClientOriginalExtension();
            // Filename to store
            $avatar = 'admin-image/' . $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('avatar')->storeAs('public', $avatar);
        }
        $admin = Admin::find($id);
        $admin->avatar = $avatar;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->address = $request->address;
        $admin->phone = $request->phone;
        $admin->save();
        if ($admin) {
            return redirect()->back()->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, try again');
        }
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

    public function passupdate(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required', new MatchOldPassword,
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        $admin = Admin::find($id);
        if (!(Hash::check($request->get('old_password'), $admin->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not match with the password you provided. Please try again.");
        }
        $admin->password = Hash::make($request->password);
        $admin->save();

        if ($admin) {
            return redirect()->back()->with('success', 'Password Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, try again.');
        }
    }
}