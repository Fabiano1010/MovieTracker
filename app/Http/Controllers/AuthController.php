<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function register(Request $request){
//        sleep(1);
        //validate
       $fields=$request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
        //register
        $user = User::create($fields);


        //login

        Auth::login($user);
        //redirect
        return redirect()->route('dashboard');

    }
    public function login(Request $request){
        $fields = $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);

        if (Auth::attempt($fields,$request->remember)) {

            $request->session()->regenerate();
            return redirect()->intended('dashboard');

        }

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

}
