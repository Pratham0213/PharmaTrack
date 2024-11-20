<?php

namespace App\Http\Controllers;

// use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Str;
use Mail;
use App\Mail\ForgotPasswordMail;
use App\Http\Requests\ResetPassword;

use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){

        return view('auth.login');
    }

    public function forgot(){
        return view('auth.forgot');
    }

    public function login_post(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // dd($request->all());
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], true)){
            if(Auth::user()->is_role == 1){
                return redirect()->intended('admin/dashboard');
            }
            else{
                return redirect()->back()->with('error', 'Please enter the correct credentials');
            }
        }else{
            return redirect()->back()->with('error', 'Please enter the correct credentials');
        }
    }

    public function forgot_post(Request $request){
        // dd($request->all());
        $count = User::where('email', '=', $request->email)->count();
        if($count > 0){
            // dd("DDDD");
            $user = User::where('email', '=', $request->email)->first();
            $user->remember_token = Str::random(50);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', 'Email for password to reset is send. Please check your email.');
        }
        else{
            return redirect()->back()->withInput()->with('error', 'Email not found. Please type valid email');
        }
    }

    public function getReset($token){
        // dd($token);
        if(Auth::check()){
            return redirect('admin/dashboard');
        }

        $user = User::where('remember_token', '=', $token);
        if($user->count() == 0){
            abort(403);
        }
        $user = $user->first();
        $data['token'] = $token;
        return view('auth.reset', $data);
    }

    public function postReset($token, ResetPassword $request){
        $user = User::where('remember_token', '=', $token);
        if($user->count() == 0){
            abort(403);
        }
        $user = $user->first();
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(50);
        $user->save();

        return redirect('/')->with('success', 'Password has been reset');

    }

    public function logout(){
        Auth::logout();
        return redirect(url('/'));
    }
}
