<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
       protected function redirectTo()
        {
            $user = Auth::user();

            if($user->role_id == env('USERS')){
                return route('user_profile', [$user->username]);
            }else{
                return route('dashboard');
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


    public function phone()
    {
        $identity  = request()->get('email');
        $fieldName = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        request()->merge([$fieldName => $identity]);

        return $fieldName;
    }
}
