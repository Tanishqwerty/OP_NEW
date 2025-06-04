<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Warehouse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('user.index', compact('users'));
    }

    public function dashbord()
    {
        $users = User::with('role')->get();
        return view('user.dashboard', compact('users'));
    }

    public function create() {
        $roles = Role::all();
        $warehouses = Warehouse::all();
        return view('user.create', compact('roles', 'warehouses'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            // 'firstname' => 'required',
            // 'lastname' => 'required',
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|min:6',
            // 'role_id' => 'required',
            
            // 'role' => 'required'
        ]);
        
        User::create([
            'name' => $request->firstname . ' ' . $request->lastname,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'warehouse_id' => $request->warehouse_id, // important!
            'usercode' => uniqid('USR'), 
            'is_active' => $request->is_active == 'Active' ? 1 : 0
        ]);
    
        return redirect()->route('user.index')->with('success', 'user created successfully.');
    } 
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $warehouses = Warehouse::all();
        return view('user.edit', compact('user' , 'roles', 'warehouses'));
    }
    

    public function update(Request $request, $id)
    {
          
        $request->merge([
            'is_active' => $request->is_active == 'Active' ? 1 : 0,
            'password' => bcrypt($request->password)
        ]);
        
            // Validate the request
            $validated = $request->validate([
                'name' => 'required', 
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email', 
                'password' => 'required',
                'role_id' => 'required',
                'warehouse_id' =>'required'
            ]);
          
            
            $user = User::findOrFail($id);
            $user->update($request->all());
         
            // Redirect or return response
            return redirect()->route('user.index')->with('success', 'User updated successfully!');
        }

        public function destroy($id)
        {
            User::findOrFail($id)->delete();
            return redirect()->route('user.index')->with('success', 'user deleted!');
        }   
    
}
