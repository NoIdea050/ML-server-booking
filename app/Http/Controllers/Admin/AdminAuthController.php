<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\User;
use App\Models\Booking;
class AdminAuthController extends Controller
{
    public function admin_login()
    {
        // Check if the admin is already logged in. If so, redirect to the dashboard.
        if (Auth::guard('admin')->check()) {
            return redirect()
                ->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function dashboard()
    {
        //get total number of users
        $user = User::count();
        //get total number of bookings
        $booking = Booking::count();
        //get total number of pending bookings
        $pending = Booking::where('status','0')->count();
        //get total number of approved bookings
        $approved = Booking::where('status','1')->count();
        //get total number of rejected bookings
        $rejected = Booking::where('status','2')->count();
         //get total number of approved bookings for current month
        $current_month = Booking::where('status','1')->whereDate('created_at',date('Y-m-d'))->count();
        return view('admin.dashboard', compact('user','booking','pending','approved','rejected','current_month'));
    }
    public function admin_login_check(Request $request)
    {
        
        $this->validate($request, [
            // The email field is required
            'email' => 'required|email',
            // The password field is required
            'password' => 'required|min:8'
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 
           'password' => $request->password], $request->get('remember'))) {
             // redirect to admin dashboard
            return redirect()
                ->route('admin.dashboard');
        }
        // redirect back to login page with error message
        return redirect()->
            back()->
            withInput($request->only('email', 'remember'))
            ->with('error', 'Invalid Credentials');
    }

    public function logout()
    {
         // Logout the admin
        Auth::guard('admin')->logout();
        // Redirect to the admin login page
        return redirect()->route('admin-login');
    }

    /**
     * Admin password reset
     *
     * This function is called when the admin user (admin) has forgotten
     * their password and needs a new one generated.
     *
     * @param string $username The username of the user to reset the password for
     * @return string The new password
    */
    public function admin_password_reset()
    {
        return view('admin.auth.password-reset-email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  Request  $request
     * @return Response
    */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:admins,email'
        ]);

        $token = \Str::random(64); // Generate a random token
        \DB::table('password_resets')->insert([ // Insert the token into the database
              'email'=>$request->email,
              'token'=>$token,
              'created_at'=>Carbon::now(),
        ]);
        //get the user's email address
        $action_link = route('admin.reset.password.form',['token'=>$token,'email'=>$request->email]);
        //create the body of the email
        $body = "We received a request to reset the password for <b>Your app Name </b> account associated with ".$request->email.". You can reset your password by clicking the link below";

       \Mail::send('admin.auth.email-forgot',['action_link'=>$action_link,'body'=>$body], function($message) use ($request){
             $message->from('noreply@example.com','Your App Name');
             $message->to($request->email,'Your name')
                     ->subject('Reset Password');
       });

       return back()->with('success', 'We have e-mailed your password reset link!');
    }

    /**
    * Reset password form
    */
    public function showResetForm(Request $request, $token = null){
        return view('admin.auth.reset')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function resetPassword(Request $request){
        // validate
        $request->validate([
            'email'=>'required|email|exists:admins,email',
            'password'=>'required|min:8|confirmed',
            'password_confirmation'=>'required',
        ]);

        // check token
        $check_token = \DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();

        if(!$check_token){
            return back()->withInput()->with('fail', 'Invalid token');
        }else{

            // update password
            Admin::where('email', $request->email)->update([
                'password'=>\Hash::make($request->password)
            ]);

            // delete token
            \DB::table('password_resets')->where([
                'email'=>$request->email
            ])->delete();

            // redirect
            return redirect()->route('admin-login')->with('info', 'Your password has been changed! You can login with new password')->with('verifiedEmail', $request->email);
        }
    }
}