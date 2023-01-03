<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMoreInfo;
use App\Models\Credit;
use App\Models\Booking;
use App\Models\Setting;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Auth;
use File;
use DateTime;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMail;

use Illuminate\Support\Facades\Auth as FacadesAuth;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $this->credit_deposit();
        return view('user.dashboard');
    }

    public function credit_deposit()
    {
        $credit = Setting::first();
        // Get the monthly credit amount
        $credit_amount = $credit->monthly_credit;

        // Get credit for user
        $credit_data = Credit::where('user_id', Auth::user()->id)->first();
        // if credit data exists
        if ($credit_data) {
            // get date of last credit added
            $last_credit_added_date = $credit_data->last_credit_added_date;
            // set timezone to London
            date_default_timezone_set('Europe/London');
            // get current date and time
            $now_date_time = date('Y-m-d h:i:s', time());

            // split date and time from $last_credit_added_date
            $d = explode(' ', $last_credit_added_date);   
            // add 1 month to the date part of $last_credit_added_date         
            $one_month_later_date_time = date('Y-m-d', strtotime("+1 month", strtotime($d[0])));
           
            // compare $one_month_later_date_time to $now_date_time
            if ($one_month_later_date_time <= $now_date_time) {
                // add credit amount to $credit_data->total_credit_gain
                $credit_data->total_credit_gain = $credit_data->total_credit_gain + $credit_amount;
                // add credit amount to $credit_data->total_credit_left
                $credit_data->total_credit_left = $credit_data->total_credit_left + $credit_amount;
                // set $credit_data->last_credit_added to $credit_amount
                $credit_data->last_credit_added = $credit_amount;
                // set $credit_data->last_credit_added_date to $one_month_later_date_time
                $credit_data->last_credit_added_date = $one_month_later_date_time. ' '. $d[1];
                // save $credit_data
                $credit_data->save();
            }
            return false;
        }
        return false;

    }

    public function booking(Request $request)
    {
        // Validate input data to the form
        $validated = $request->validate([
            'start_date_and_time'=> 'required',
            'end_date_and_time' => 'required',
            'type' => 'required',
            'note' => 'nullable',
        ]);
        
        // First we get the start and end dates and convert them to the format we need for the query
        $start_date_and_time = date("Y-m-d H:i:s", strtotime($request->start_date_and_time));
        $end_date_and_time = date("Y-m-d H:i:s", strtotime($request->end_date_and_time));
        // Then we build a subquery to check if the start or end dates are between the start and end dates of an existing booking
        $check_data = Booking::select('start_date_and_time', 'end_date_and_time', 'status', 'type')
                        ->where(function($query) use ($start_date_and_time, $end_date_and_time) {
                            $query->where(function($query1) use ($start_date_and_time) {
                                        $query1->where('start_date_and_time', '<=', $start_date_and_time)
                                            ->where('end_date_and_time', '>=', $start_date_and_time);
                                    })
                                    ->orWhere(function($query2) use ($end_date_and_time) {
                                        $query2->where('start_date_and_time', '<=', $end_date_and_time)
                                            ->where('end_date_and_time', '>=', $end_date_and_time);
                                    });
                        })->where('status', 1)->where('type', $request->type)->first();

        if ($check_data) {
            // check if slot not empty in your booking range
            return redirect()->back()->withInput($request->all())->with('error', 'Slot not empty in your booking range.');
        }
        
        $data = new Booking; // A new booking object
        $data->user_id = Auth::user()->id; // Get the current user's ID and add it to the booking object
        $data->start_date_and_time = $request->start_date_and_time; // Get the start date from the form and add it to the booking object
        $data->end_date_and_time = $request->end_date_and_time; // Get the end date from the form and add it to the booking object
        $data->type = $request->type; // Get the type from the form and add it to the booking object
        $data->note = $request->note; // Get the note from the form and add it to the booking object
        $data->save(); // Save the booking object to the database
        if ($data) {

            $email_data = [
                'name' => Auth::user()->name, // The name of the current user
                'booking_data' => $data, // The data of the booking request
                'credit_data' => Credit::where('user_id', Auth::user()->id)->first(), // The data of the credits of the current user
                'title' => 'Request For Booking', // The title of the email
                'subject' => 'Booking Request', // The subject of the email
            ];
            Mail::to(Auth::user()->email)->send(new BookingMail($email_data));

            return redirect()
                ->back()
                ->with('success', 'Booked Successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something Went Wrong, Try Again.');
        }
    }

    public function booking_destroy($id)
    {
        $data = Booking::find($id); // get the record from the database
        $data->delete(); // delete the record
        if ($data) { // check if the record deleted successfully
            return redirect()
                ->back()
                ->with('success', 'Deleted Successfully'); // return with success message
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something Went Wrong, Try Again.'); // return with error message
        }
    }

    public function booking_history(){
        return view('user.booking-history', [
            'datas' => Booking::where('user_id', Auth::user()->id)->latest()->get(), // get all booking with current logged in user
            'credits' => Credit::where('user_id',Auth::user()->id)->latest()->get()]); // get all credits with current logged in user
    }
    
    public function booking_check(Request $request)
    {
        $picking_date = $request->picking_date;

        //Get all CPU bookings for the date
        $cpu_datas = Booking::select('start_date_and_time', 'end_date_and_time', 'status', 'type')
                            ->whereDate('start_date_and_time', '<=', $picking_date)
                            ->WhereDate('end_date_and_time', '>=', $picking_date)
                            ->where('status', 1)->where('type', 'CPU')->get();
        //Get all GPU bookings for the date
        $gpu_datas = Booking::select('start_date_and_time', 'end_date_and_time', 'status', 'type')
                            ->whereDate('start_date_and_time', '<=', $picking_date)
                            ->WhereDate('end_date_and_time', '>=', $picking_date)
                            ->where('status', 1)->where('type', 'GPU')->get();

        return $return_data = [
            'cpu_datas' => $cpu_datas,
            'gpu_datas' => $gpu_datas,
        ];
    }

    public function profile(){
        // get the user information
        $data = User::with('user_more_info')
            ->where('id', Auth::user()->id)
            ->first();
        return view('user.profile', compact('data'));
    }
    
    /**
     * Updating profile info
     */
    public function profile_update(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'nullable',
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::user()->id),
            ],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $avatar = $request->old_img;
        if (request()->hasFile('avatar')) {
            //old image delete after updating
            // File::delete(public_path('storage/' . $request->old_img));
            if(File::exists('storage/'.$request->old_img)) {
                if($request->old_img){
                    unlink('storage/'.$request->old_img);
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
            $avatar = 'user-image/' . $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('avatar')->storeAs('public', $avatar);
        }
        $user_info = UserMoreInfo::where('user_id', Auth::user()->id)->first();
        if (empty($user_info)) {
            $user_info = new UserMoreInfo();
            $user_info->user_id = $user->id;
        }
        $user_info->avatar = $avatar;
        $user_info->phone = $request->phone;
        $user_info->save();
        if ($user_info) {
            return redirect()
                ->back()
                ->with('success', 'Updated Successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something went wrong, try again.');
        }
    }

    /**
    * 
    * Updating password
    * 
    */
    public function passupdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            new MatchOldPassword(),
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        $data = User::find(Auth::user()->id);
        if (!Hash::check($request->get('old_password'), $data->password)) {
            // The passwords matches
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Your current password does not match with the password you provided. Please try again.'
                );
        }
        $data->password = Hash::make($request->password);
        $data->save();
        if ($data) {
            return redirect()
                ->back()
                ->with('success', 'Password Updated Successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something went wrong, try again.');
        }
    }
}