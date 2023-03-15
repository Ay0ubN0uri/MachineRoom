<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Mail\Mails;
use Illuminate\Support\Facades\Mail;

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

        // Send email to the admin just created
        Mail::to($formFields['email'])->send(new Mails($formFields['email'], $formFields['password']));
        
        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);
        return back()->with('message', "Compte créé, un email a été envoyé à " . $formFields['name']);
    }

    // delete user by super admin
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé']);
        }

        $user->delete();

        return response()->json(['success' => 'Utilisateur supprimé avec succès']);
    }


    // Logout User
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');

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
            return back()->with('disabledAccountMessage','Désolé! Ton compte est désactivé!');
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
