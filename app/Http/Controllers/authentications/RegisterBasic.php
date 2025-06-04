<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }
  public function create() {
    return view('customer.create');
  }
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:customer',
      'password' => 'required|string|min:6|confirmed',
      'role' => 'required|string',
      ]);
      Customer::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
         'role' => $request->role,
    ]);
      return redirect()->route('customer.index')->with('success', 'customer created successfully!');
  }
}
