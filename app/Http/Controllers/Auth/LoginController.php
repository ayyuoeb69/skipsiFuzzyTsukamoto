<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if ( $user->status == 0 ) {
            return redirect()->route('admin_utama_beranda');
        }else if ( $user->status == 1 ) {
            return redirect()->route('admin_sungai_beranda');
        }else if ( $user->status == 2 ) {
            return redirect()->route('relawan_beranda');
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            $this->username() => ['required', 'string',  'max:255'],
            'password' => ['required', 'string'],
        ]);
    }
    public function username()
    {
        return 'username';
    }
    protected function credentials(Request $request)
    {

        return array_merge($request->only($this->username(), 'password'));

    }
}
