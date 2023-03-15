<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminHome(){
        return view("admin.home");
    }

    public function getStatistics(){
        $results = DB::table('rooms as r')
            ->leftJoin('machines as m', 'r.id', '=', 'm.room_id')
            ->select('r.id', 'r.label', DB::raw('COUNT(m.id) as nbrMachines'))
            ->groupBy(['r.id', 'r.label'])
            ->get();

        return response()->json($results);
    }
}
