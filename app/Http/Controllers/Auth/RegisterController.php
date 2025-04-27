<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request){
        if($request->isMethod('post')){

        $validated = $request->validate([
            'name' => 'required|max:12|min:2',
            'email' => 'required|max:40|min:5|unique:users,email|email',
            'password' => 'required|max:20|min:8|alpha_num|not_regex:/^[ぁ-ゞ ァ-ヴー]/u|confirmed',
        ]);

            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
            \Session::flash('msg' , $name);
            return redirect('added');
        }
        return view('auth.register');
    }

    public function added(){
        return view('auth.added');
    }
}
