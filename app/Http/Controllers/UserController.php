<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
        return view('auth.register');
    }
    
    // This will return users to populate dataTable(super_admin)
    public function getData()
    {
        $data = DB::table('users')
        ->select('id', 'name', 'email', 'created_at', 'updated_at', 'status')
        ->where('role', '=', 'admin')
        ->get();

        return response()->json(['data' => $data]);
    }

    public function activateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->input('status');
        $user->save();
    
        return response()->json(['success' => true]);
    }

    // Create New User
    public function store(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/dashboard')->with('message', 'User created and logged in');
    }

    // Logout User
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'You have been logged out!');

    }

    // Show Login Form
    public function login() {
        return view('auth.login');
    }

    // Authenticate User
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        $user = User::where('email', $formFields['email'])->first();
        
        if($user->status == 'disabled'){
            return back()->with('disabledAccountMessage','Sorry! Your account is disabled!');
        }

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();
            
            if($user->role == 'super_admin')
                return redirect('/dashboard');
            else
                return redirect('/admin/home');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function resetPassword(){
        return view('auth.reset_password');
    }
}
