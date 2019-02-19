<?php

namespace Emarketing\Http\Controllers;

use Emarketing\Producer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            "email" => 'required',
            "password" => 'required'
        ]);

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if(Auth::guard("producer")->attempt($credentials)){
            return redirect(url("producer"));
        }

        return redirect(url("producer/login"))->withErrors(["error"=>"Invalid credentials"]);
    }

    public function adminLogin(Request $request){
        $this->validate($request, [
            "username" => 'required',
            "password" => 'required'
        ]);
        $credentials = [
            "username" => $request->username,
            "password" => $request->password
        ];

        if(Auth::guard("admin")->attempt($credentials)){
            return redirect(url("admin"));
        }

        return redirect(url("admin/login"))->withErrors(["error"=>"Invalid credentials"]);
    }

    public function register(Request $request){
        $this->validate($request, [
            "name"=> 'required',
            "email"=> 'required',
            "password"=> 'required',
            "phone" => 'required',
            "location" => 'required'
        ]);

        $details = [
            "name"=> $request->name,
            "email"=> $request->email,
            "password"=> bcrypt($request->password),
            "phone"=> $request->phone,
            "location"=> $request->location,
            "photo"=> "no-image.png"
        ];

        if(Producer::where("email", $details["email"])->exists())
            return redirect(url('producer/register'))->withErrors(["error"=> "Email exists"]);

        if(!is_null(Producer::create($details)))
            return redirect(url('producer/login'))->withErrors(["info"=> "Registration successful"]);

        return redirect(url('producer/register'))->withErrors(["error"=> "An error occured. Please try again"]);
    }
}
