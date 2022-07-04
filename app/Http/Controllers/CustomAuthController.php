<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\Session;

class CustomAuthController extends Controller
{
    //
    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function register_user(Request $request){
       $request->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:5|max:12',
       ]);
       $user = new User();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = Hash::make($request->password);
       $res = $user->save();
       if($res){
        return back()->with('success','Succesfully registered!!');
       }else{
        return back()->with('fail','Failed to registered!!');
       }

    }

    public function login_user(Request $request){
        // return "Logging in!!";
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12',
        ]);
        $user = User::where('email','=',$request->email)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                $request->session()->put('loginId',$user->id);
                return redirect('dashboard');
            }
            else{
                return back()->with('fail','Password mismatch!!');
            }
        }else{
            return back()->with('fail','Email not registered!!');
        }
    }

    public function dashboard(){
        $data = array();
        if(Session()->has('loginId')){
            $data = User::where('id','=',Session()->get('loginId'))->first();
        }

        return view("dashboard",compact('data'));
        // return view("dashboard");
    }

    public function logout(){
        // return "Logging out!!";
        if(Session()->has('loginId')){
            Session()->pull('loginId');
            return redirect('login');
        }
    }
}
