<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    //
    public function profile(){
        return view('users.profile');
    }
    public function search(){
        return view('users.search');
    }

       public function userCreate(Request $request)
    {

        $request->validate([
              'userName' => 'required|unique:users,name|max:10',
        ]);
        $name = $request->input('usersName');
        User::create(['name' => $name]);
        return back();
    }
}

    public function get_user($user_id){

        $user = User::with('following')->with('followed')->findOrFail($user_id);
        return response()->json($user);
    }
