<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-admin-login');
  }

  public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user_exist = User::where('email', $request->email)->first();

        if(!$user_exist){
            return redirect()->back()->with('error', 'The provided credentials do not match our records.');
        }

        if(!$user_exist->is_active){
            return redirect()->back()->with('error', 'User is deactivated');
        }

       if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             $request->session()->regenerate();

             $user = Auth::user(); 
             $role = $user->role->name ?? null; 

             if ($role === 'admin') {
                 return redirect()->intended('dashboard');
             } else {
                 Auth::logout();
                 return redirect()->route('adminlogin')->with('error', 'Unauthorized role');
             }
             return redirect()->back()->withErrors([
                'login' => 'Not a valid user. Please check your credentials.',
             ])->withInput();
        }
         return redirect()->back()->with('error', 'Not a valid user.');
    }

    public function show(Request  $request){
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
    
        $user = User::find($userId);
    
        if ($user) {
            return view('dashboard', compact('user'));
        }
       
    
        return redirect()->route('login')->with('error', 'User not found.');
    }
    

    
}
