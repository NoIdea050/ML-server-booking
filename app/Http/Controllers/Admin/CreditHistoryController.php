<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CreditHistory;
use App\Models\Credit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMail;
use App\Mail\CreditMail;

class CreditHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::find($user_id);
        $datas = CreditHistory::where('user_id', $user_id)->get()->sortDesc();
        return view('admin.pages.credit-history-management.index',compact('datas', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        $user = User::find($user_id);
        return view('admin.pages.credit-history-management.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input data to the form
        $validated = $request->validate([
            'user_id'=> 'required',
            'date_and_time' => 'required',
            'credit' => 'required|numeric|min:0|not_in:0',
        ]);
        // return $request->all();

        DB::beginTransaction(); //transaction start

        $credit_history = New CreditHistory;
        $credit_history->user_id = $request->user_id;
        $credit_history->credit = $request->credit;
        $credit_history->date_and_time = $request->date_and_time;
        $credit_history->save();

        $credit_data = Credit::where('user_id', $request->user_id)->first();
        $credit_data->total_credit_gain = $credit_data->total_credit_gain + $request->credit;
        $credit_data->total_credit_left = $credit_data->total_credit_left + $request->credit;
        $credit_data->last_credit_added = $request->credit;
        $credit_data->last_credit_added_date = $request->date_and_time;
        $credit_data->save();

        // dd(CreditHistory::find($credit_history->id));

        DB::commit(); //transaction end

        if ($credit_history && $credit_data) {

            $user = User::find($credit_history->user_id);
            // CreditMail
            // Array of data to be used in the email view
            $email_data = [
                'subject' => 'Extra Credit',
                'title' => 'Extra Credit Deposit',
                'credit_update' => 0,
                'message_to_user' => "You got extra ".$request->credit." credit(s). Check your account.",
                'name' => $user->name,
                'email' => $user->email,
                'credit_data' => Credit::where('user_id', $user->id)->first(),
                'credit_history' => CreditHistory::find($credit_history->id),
                'thanks_msg' => 'Thank you.',
                
            ];
            // Send the email to the admin
            Mail::to($user->email)->send(new CreditMail($email_data));

            return redirect()
                    ->back()
                    ->with('success', 'Credit Added successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something Went Wrong, Try Again.');
        } 

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
        $data = CreditHistory::find($id);
        return view('admin.pages.credit-history-management.edit',compact('data'));
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
        // Validate input data to the form
        $validated = $request->validate([
            'date_and_time' => 'required',
            'credit' => 'required|numeric|min:0|not_in:0',
        ]);
        // return $request->all();

        DB::beginTransaction(); //transaction start

        $credit_history = CreditHistory::find($id);
        $last_credit_history_data = CreditHistory::where('user_id', $credit_history->user_id)->latest()->first();
        $credit_data = Credit::where('user_id', $credit_history->user_id)->first();

        $old_credit = $credit_history->credit;

        // return $credit_history->credit - $request->credit;
        if (
                ($request->credit < $credit_history->credit) && 
                ($credit_data->total_credit_left < ($credit_history->credit - $request->credit))
            ) {
                return redirect()->back()->with('error', 'User does not have enough credit to deduct.');
        }

        $credit_data->total_credit_gain = $credit_data->total_credit_gain - $credit_history->credit + $request->credit;
        $credit_data->total_credit_left = $credit_data->total_credit_left - $credit_history->credit + $request->credit;
        if ($last_credit_history_data->id == $credit_history->id) {
            $credit_data->last_credit_added = $request->credit;
        }
        $credit_data->save();

        $credit_history->credit = $request->credit;
        $credit_history->save();


        $user = User::find($credit_history->user_id);
        // CreditMail
        // Array of data to be used in the email view
        $email_data = [
            'subject' => 'Credit Update',
            'title' => 'Credit Deposit Update',
            'credit_update' => 1,
            'message_to_user' => "Given old credit has been updated to ".$request->credit." credit(s)(old:".$old_credit."). Check your account.",
            'name' => $user->name,
            'email' => $user->email,
            'credit_data' => Credit::where('user_id', $user->id)->first(),
            'credit_history' => CreditHistory::find($credit_history->id),
            'old_credit' => $old_credit,
            'thanks_msg' => 'Thank you.',
            
        ];
        // Send the email to the admin
        Mail::to($user->email)->send(new CreditMail($email_data));


        DB::commit(); //transaction end

        if ($credit_history && $credit_data) {
            return redirect()
                    ->back()
                    ->with('success', 'Credit Added successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something Went Wrong, Try Again.');
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

        DB::beginTransaction(); //transaction start

        $credit_history = CreditHistory::find($id);
        $credit_history_back_up = $credit_history;

        $last_credit_history_data = CreditHistory::where('user_id', $credit_history->user_id)->where('status', 1)->latest()->first();
        $credit_data = Credit::where('user_id', $credit_history->user_id)->first();

        // return $credit_history->credit - $request->credit;
        if ($credit_data->total_credit_left < $credit_history->credit) {
                return redirect()->back()->with('error', 'User does not have enough credit to deduct.');
        }

        $credit_data->total_credit_gain = $credit_data->total_credit_gain - $credit_history->credit;
        $credit_data->total_credit_left = $credit_data->total_credit_left - $credit_history->credit;
        if ($last_credit_history_data->id == $credit_history->id) {
            $now_last_credit_history_data = CreditHistory::where('user_id', $credit_history->user_id)->where('id', '<', $last_credit_history_data->id)->latest()->where('status', 1)->first();
            if ($now_last_credit_history_data) {
                $credit_data->last_credit_added = $now_last_credit_history_data->credit;
            }else {
                $credit_data->last_credit_added = $credit_data->last_credit_added - $last_credit_history_data->credit;
            }
        }
        $credit_data->save();


        $credit_history->delete();

        $user = User::find($credit_history_back_up->user_id);
        // CreditMail
        // Array of data to be used in the email view
        $email_data = [
            'subject' => 'Remove Credit',
            'title' => 'Given Extra Credit[Removed]',
            'credit_update' => 2, //2->deleted
            'message_to_user' => "Sorry for inconvenience. That was a mistake",
            'name' => $user->name,
            'email' => $user->email,
            'credit_data' => Credit::where('user_id', $user->id)->first(),
            'credit_history' => $credit_history_back_up,
            'thanks_msg' => 'Thanks You.',
            
        ];
        // Send the email to the admin
        Mail::to($user->email)->send(new CreditMail($email_data));

        DB::commit(); //transaction end

        if ($credit_history && $credit_data) {
            return redirect()
                    ->back()
                    ->with('success', 'Data Deleted successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something Went Wrong, Try Again.');
        }
    }

    public function reject($id)
    {
        DB::beginTransaction(); //transaction start

        $credit_history = CreditHistory::find($id);

        if ($credit_history->status == 0 || $credit_history->status == 2) {
            $credit_history->status = 2;
            $credit_history->save();

            $user = User::find($credit_history->user_id);
            // CreditMail
            // Array of data to be used in the email view
            $email_data = [
                'subject' => 'Credit Request[Rejected]',
                'title' => 'Request For Extra Credit[Rejected]',
                'credit_update' => 0,
                'message_to_user' => "Requested extra credit has been rejected.",
                'name' => $user->name,
                'email' => $user->email,
                'credit_data' => Credit::where('user_id', $user->id)->first(),
                'credit_history' => $credit_history,
                'thanks_msg' => 'Thanks for your patience. Try again later.',
                
            ];
            // Send the email to the admin
            Mail::to($user->email)->send(new CreditMail($email_data));

            DB::commit(); //transaction end
            return redirect()
                    ->back()
                    ->with('success', 'Request for credit rejected successfully.');
        }
        return redirect()
                ->back()
                ->with('error', 'You can not deleted the request.');
    }

    public function accept($id)
    {
        DB::beginTransaction(); //transaction start

        $credit_history = CreditHistory::find($id);

        if ($credit_history->status == 0 || $credit_history->status == 2) {
            $credit_history->date_and_time = date('Y-m-d H:m:s');
            $credit_history->status = 1;
            $credit_history->save();

            $credit_data = Credit::where('user_id', $credit_history->user_id)->first();
            $credit_data->total_credit_gain = $credit_data->total_credit_gain + $credit_history->credit;
            $credit_data->total_credit_left = $credit_data->total_credit_left + $credit_history->credit;
            $credit_data->last_credit_added = $credit_history->credit;
            $credit_data->last_credit_added_date = date('Y-m-d H:m:s');
            $credit_data->save();

            $user = User::find($credit_history->user_id);
            // CreditMail
            // Array of data to be used in the email view
            $email_data = [
                'subject' => 'Credit Request[Accepted]',
                'title' => 'Request For Extra Credit[Accepted]',
                'credit_update' => 0,
                'message_to_user' => "Requested extra credit has been deposited to your account.",
                'name' => $user->name,
                'email' => $user->email,
                'credit_data' => Credit::where('user_id', $user->id)->first(),
                'credit_history' => $credit_history,
                'thanks_msg' => 'Thanks for your patience.',
                
            ];
            // Send the email to the admin
            Mail::to($user->email)->send(new CreditMail($email_data));

            DB::commit(); //transaction end
            return redirect()
                    ->back()
                    ->with('success', 'Request for credit accepted successfully.');
        }
        return redirect()
                ->back()
                ->with('error', 'You can not deleted the request.');
    }
}
