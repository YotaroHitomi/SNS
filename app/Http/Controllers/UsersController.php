<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\FollowUser;

class UsersController extends Controller
{
    //
    public function profile(){
        return view('users.profile');
    }



    //登録用
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
