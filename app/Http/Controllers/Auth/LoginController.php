<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;
    protected function redirectTo()
    {
        if (Auth::check() && Auth::user()->role_id == 5 && Auth::user()->status == 1){
            return '/user/dashboard';
        }elseif (Auth::check() && Auth::user()->role_id == 1){
            return '/superadmin/dashboard';
        } elseif (Auth::check() && Auth::user()->role_id == 2){
            return '/admin/dashboard';
        }elseif (Auth::check() && Auth::user()->role_id == 3){
            return '/moderator/dashboard';
        }elseif (Auth::check() && Auth::user()->role_id == 4){
            return '/member/dashboard';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {   
        $input = $request->all();

  
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
  
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            if (Auth::check() && Auth::user()->status == 0) {
                Auth::logout();
                return redirect()->route('login')
                                ->with('error', 'Account is not active yet.');
            }
            return redirect()->route('user.dashboard');
        }else{
            return redirect()->route('login')
                ->with('error','Email-Address or User-Name And Password Are Wrong.');
        }
          
    }
}