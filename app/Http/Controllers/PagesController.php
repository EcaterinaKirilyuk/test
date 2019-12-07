<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PagesController extends Controller
{
    public function index()
    {
        return view('login');
    }


    public function login(Request $request)
    {

        $conditions = [
            ['name', '=', $request->name],
            ['email', '=', $request->email],
            ['password','=', $request->password]
        ];

        $user =  User::where($conditions)->first();

        if($user){

            echo "true";

        }else{
            echo "false";
        }
    }

    public function loginHash(Request $request)
    {

        $conditions = [
            ['name', '=', $request->name],
            ['email', '=', $request->email],
        ];

        $user =  User::where($conditions)->first();

        $passwordCheck = Hash::check($request->password, $user->password);

        if($passwordCheck){

            echo "true";

        }else{
            echo "false";
        }
    }

    public function welcome()
    {
        return view('welcome');
    }
}

