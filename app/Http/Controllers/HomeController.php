<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\CheckOldPassword;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

     public function showChangePasswordForm(){
        return view('auth.changepassword');
    }
    public function changePassword(Request $request){
        
        $request->validate([
            'old_password' => ['required', new CheckOldPassword],
            'password' => 'required|string|min:8|confirmed|different:old_password',

        ]);
        
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();
        return redirect()->back()->with("success","Password alterada com sucesso!");
    }
}
