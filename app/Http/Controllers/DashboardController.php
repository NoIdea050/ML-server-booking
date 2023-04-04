<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMoreInfo;
use App\Models\Credit;
use App\Models\Booking;
use App\Models\Setting;
use App\Models\CreditHistory;
use App\Models\Storage;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Auth;
use File;
use DateTime;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMail;
use App\Mail\CreditMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth as FacadesAuth;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $storages = Storage::where('status', 1)->orderBy('type')->get();
        return view('user.dashboard',[
            'storages' => $storages,
        ]);
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
            'storage' => 'required',
            'note' => 'nullable',
        ]);

        try{
            DB::beginTransaction(); //transaction start
        
            // First we get the start and end dates and convert them to the format we need for the query
            $start_date_and_time = date("Y-m-d H:i:s", strtotime($request->start_date_and_time));
            $end_date_and_time = date("Y-m-d H:i:s", strtotime($request->end_date_and_time));

            $start_timestamp = strtotime($start_date_and_time);
            $end_timestamp = strtotime($end_date_and_time);
            $difference = $end_timestamp - $start_timestamp;
            $difference_in_minutes = floor($difference / 60);
            if($difference_in_minutes < 60){
                return redirect()->back()->withInput($request->all())->with('error', 'You have to book for minimum one hour');
            }

            $user_credit = Credit::Where('user_id',Auth::user()->id)->first();
            $storages = Storage::find($request->storage);

            $cost = $storages->cost_per_hour;
            $cost_will_be = number_format((($cost/60)*$difference_in_minutes), 2);
            // Check if user has enough credit to return
            if ($user_credit->total_credit_left < $cost_will_be) {
                return redirect()->back()->withInput($request->all())->with('error', 'Not enough credit is available!');
            }

            // Then we build a subquery to check if the start or end dates are between the start and end dates of an existing booking
            $check_data = Booking::select('start_date_and_time', 'end_date_and_time', 'status', 'storage_id')
                            ->where(function($query) use ($start_date_and_time, $end_date_and_time) {
                                $query->where(function($query1) use ($start_date_and_time) {
                                            $query1->where('start_date_and_time', '<=', $start_date_and_time)
                                                ->where('end_date_and_time', '>=', $start_date_and_time);
                                        })
                                        ->orWhere(function($query2) use ($end_date_and_time) {
                                            $query2->where('start_date_and_time', '<=', $end_date_and_time)
                                                ->where('end_date_and_time', '>=', $end_date_and_time);
                                        });
                            })->where('status', 1)->where('storage_id', $request->storage)->first();

            if ($check_data) {
                // check if slot not empty in your booking range
                return redirect()->back()->withInput($request->all())->with('error', 'Slot not empty in your booking range.');
            }
            
            $data = new Booking; // A new booking object
            $data->user_id = Auth::user()->id; // Get the current user's ID and add it to the booking object
            $data->start_date_and_time = $request->start_date_and_time; // Get the start date from the form and add it to the booking object
            $data->end_date_and_time = $request->end_date_and_time; // Get the end date from the form and add it to the booking object
            $data->storage_id = $request->storage; // Get the storage_id from the form and add it to the booking object
            $data->note = $request->note; // Get the note from the form and add it to the booking object
            $data->credit_cost = $cost_will_be; // Get the credit_cost from the form and add it to the booking object
            
            // Set the status of the request to 1 (approved)
            $data->status = 1;
            // Set the credit of the user to the current credit
            $data->credit = $user_credit->total_credit_left;

            $data->save(); // Save the booking object to the database

            $user_credit->total_credit_left = $user_credit->total_credit_left - $cost_will_be;
            $user_credit->save();

            DB::commit(); //transaction end

            if ($data) {

                $email_data = [
                    'name' => Auth::user()->name, // The name of the current user
                    'booking_data' => $data, // The data of the booking request
                    'credit_data' => Credit::where('user_id', Auth::user()->id)->first(), // The data of the credits of the current user
                    'title' => 'Booking Request Accepted', // The title of the email
                    'subject' => 'Booking Acceptance', // The subject of the email
                ];
                Mail::to(Auth::user()->email)->send(new BookingMail($email_data));

                return redirect()
                    ->back()
                    ->with('success', 'Booked successfully');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Something Went Wrong, Try Again.');
            }   
        }catch(Exception $e){
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
            'credits' => Credit::where('user_id',Auth::user()->id)->latest()->get(), // get all credits with current logged in user
            'credit_histories' => CreditHistory::where('user_id',Auth::user()->id)->latest()->get() // get all credits history with current logged in user
        ]);
    }
    
    public function booking_check(Request $request)
    {
        $picking_date = $request->picking_date;

        //Get all bookings for the date
        $booking_datas = Booking::select('id', 'start_date_and_time', 'end_date_and_time', 'status', 'storage_id')
                            ->whereDate('start_date_and_time', '<=', $picking_date)
                            ->WhereDate('end_date_and_time', '>=', $picking_date)
                            ->where('status', 1)->orderBy('storage_id')->orderBy('start_date_and_time', 'ASC')->get();

        return count($booking_datas) > 0 ? $booking_datas : 'No Data Found';
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
            'phone' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $avatar = $request->old_img;
        if (request()->hasFile('avatar')) {
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


    public function request_for_credit(Request $request)
    {
        $request->validate([
            'credit' => 'required|numeric|min:0|not_in:0',
            'message' => 'nullable|max:300',
        ]);

        DB::beginTransaction(); //transaction start

        $credit_history = New CreditHistory;
        $credit_history->user_id = Auth::user()->id;
        $credit_history->credit = $request->credit;
        $credit_history->requested_date_and_time = date('Y-m-d H:i:s');
        $credit_history->message = $request->message;
        $credit_history->status = 0;
        $credit_history->save();

        DB::commit(); //transaction end

        if ($credit_history) {

            // CreditMail
            // Array of data to be used in the email view
            $email_data = [
                'subject' => 'Credit Request',
                'title' => 'Request For Extra Credit',
                'credit_update' => 0,
                'message_to_user' => "We'll let you know when your credit has been deposited or rejected.",
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'credit_data' => Credit::where('user_id', Auth::user()->id)->first(),
                'credit_history' => $credit_history,
                'thanks_msg' => 'Thanks for your patience .',
                
            ];
            // Send the email to the admin
            Mail::to(Auth::user()->email)->send(new CreditMail($email_data));
            
            return redirect()
                    ->back()
                    ->with('success', 'Request for credit successfully done.');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something Went Wrong, Try Again.');
        }
    }

    public function request_for_credit_delete($id)
    {

        DB::beginTransaction(); //transaction start

        $credit_history = CreditHistory::find($id);

        if ($credit_history->status == 0 || $credit_history->status == 2) {
            $credit_history->delete();

            DB::commit(); //transaction end
            return redirect()
                    ->back()
                    ->with('success', 'Request for credit deleted successfully.');
        }
        return redirect()
                ->back()
                ->with('error', 'You can not delete the request.');
    }

    public function bookingsJson()
    {
        $bookings = Booking::with('user')->get()->sortDesc();
        $bookingData = [];
        foreach ($bookings as $booking) {
            $bookingData[] = [
                'id' => $booking->id,
                'username' => $booking->user->name,
                'start_date_and_time' => $booking->start_date_and_time,
                'end_date_and_time' => $booking->end_date_and_time,
                'credit' => $booking->credit,
                'credit_cost' => $booking->credit_cost,
                'status' => $booking->status,
                'created_at' => $booking->created_at,
                'updated_at' => $booking->updated_at
            ];
        }
        return response()->json(['data' => $bookingData]);
        
    }
}