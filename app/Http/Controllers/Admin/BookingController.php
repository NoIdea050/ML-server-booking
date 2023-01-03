<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Credit;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMail;

class BookingController extends Controller
{
    public function index()
    {
        $datas = Booking::with('user')->get()->sortDesc();
        return view('admin.pages.booking-management.index',compact('datas'));
    }

    public function booking_apporved(Request $request,$id)
    {
        $this->validate($request, [
            'credit_left' => 'required',
        ]);

        $row = Booking::find($id);

        // Get the start date and time from the database
        $start_date_and_time = date("Y-m-d H:i:s", strtotime($row->start_date_and_time));
        // Get the end date and time from the database
        $end_date_and_time = date("Y-m-d H:i:s", strtotime($row->end_date_and_time));
        // Check if the start date and time is in between the start date and time and end date and time
        // or the end date and time is in between the start date and time and end date and time
        // of the database
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
                        })->where('id', '!=', $id)->where('status', 1)->where('type', $row->type)->first();
        // If the start date and time or the end date and time is in between the start date and time and end date and time
        // of the database then redirect back with an error message
        if ($check_data) {
            return redirect()->back()->withInput($request->all())->with('error', 'This Slot Is Already Taken.');
        }
        
        // Get user credit
        $user_credit = Credit::Where('user_id',$row->user_id)->first();
        // Check if user has enough credit to return
        if ($user_credit->total_credit_left < $request->credit_left) {
            return redirect()->back()->withInput($request->all())->with('error', 'Not enough credit is available!');
        }

        // Set the status of the request to 1 (approved)
        $row->status = 1;
        // Set the credit of the user to the current credit
        $row->credit = $user_credit->total_credit_left;
        // Set the credit cost of the request to the credit cost of the request
        $row->credit_cost = $request->credit_left;
        // Save the request
        $row->save();
        
        
        $user_credit->total_credit_left = $user_credit->total_credit_left - $request->credit_left;
        $user_credit->save();

        // Array of data to be used in the email view
        $email_data = [
            'name' => $row->user->name,
            'booking_data' => $row,
            'credit_data' => Credit::where('user_id', $row->user->id)->first(),
            'title' => 'Booking Request Accepted',
            'subject' => 'Booking Acceptance',
        ];
        // Send the email to the user
        Mail::to($row->user->email)->send(new BookingMail($email_data));

        return redirect()
                ->back()
                ->with('success', 'Booked Successfullly');
    }
    public function booking_rejected($id)
    {
        // Find the row in the booking table where the id is equal to the $id variable
        $row = Booking::find($id);
        
        // If the status of the booking is equal to 2,
        if ($row->status == 2) {
            // Change the status of the booking to 0
            $row->status = 0;
        } else {
            // Else change the status of the booking to 2
            $row->status = 2;
        }
        // Save the changes to the database
        $row->save();

        // Array with the data needed to send the email
        $email_data = [
            'name' => $row->user->name, // Get the name from the user table
            'booking_data' => $row, // Get the booking data from the table
            'credit_data' => Credit::where('user_id', $row->user->id)->first(), // Get the credit data from the table
            'title' => 'Booking Request Rejected', // Title of the email
            'subject' => 'Booking Rejection', // Subject of the email
        ];
        // Send the email
        Mail::to($row->user->email)->send(new BookingMail($email_data));

        return redirect()
            ->back()
            ->with('success', 'Status Changed successfully!');
    }
}