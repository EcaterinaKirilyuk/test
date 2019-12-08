<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name'  => 'required|max:8',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return json_encode(['status' => false ,'error' => implode(',' , $validator->messages()->all())]);
        }

        $conditions = [
            ['name', '=', $request->name],
            ['email', '=', $request->email],
        ];

        $user =  User::where($conditions)->first();

        if($user)
        {
            $passwordCheck = Hash::check($request->password, $user->password);
        }
        else
        {
            return json_encode([ "status"=> false, 'error' => 'Incorrect Username or Email' ]);
        }

        if($passwordCheck)
        {
            $request->session()->put('user_id', $user->id);
            return json_encode([ "status"=> true ]);
        }
        else
        {
            return json_encode([ "status"=> false, 'error' => 'Incorrect Password' ]);
        }
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'nullable|max:8',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:8',
        ]);

        if ($validator->fails()) {
            return json_encode(['status' => false ,'error' => implode(',' , $validator->messages()->all())]);
        }

        $id = $request->session()->get('user_id');

        $user =  User::where('id', '=', $id)->first();

        if($request->name)
        {
            $user->name = $request->name;
        }

        if($request->email)
        {
            $user->email = $request->email;
        }

        if($request->password)
        {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return json_encode([ "status"=> true ]);
    }

    public function editForm()
    {
        return view('edit');
    }
}

