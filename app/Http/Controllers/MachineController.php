<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        return view('admin.machine');
    }

    public function fetchMachines()
    {
        $data = Machine::all();
        return response()->json(['data' => $data]);
    }
}
