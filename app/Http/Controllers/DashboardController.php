<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $deactivated = User::where('status', 'disabled')->where('role', 'admin')->count();;
        $activated = User::where('status', 'active')->where('role', 'admin')->count();;
        $total = User::where('role', 'admin')->count();

        return view('super_admin.dashboard', [
            'usersDeactivated' =>  $deactivated,
            'usersActivated' => $activated,
            'totalUsers' => $total
        ]);
    }
}
