<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.room');
    }

    public function fetchRooms()
    {
        // $data = DB::table('users')
        // ->select('id', 'name', 'email', 'created_at', 'updated_at', 'status')
        // ->where('role', '=', 'admin')
        // ->get();
        $data = Room::all();
        return response()->json(['data' => $data]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $room = new Room();
        $room->code = $request->code;
        $room->label = $request->label;
        $room->save();
        return response()->json(['status'=>true]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room )
    {
        $room->fill([
            'code'=>$request->code,
            'label'=>$request->label
        ]);
        $room->save();
        return response()->json(['status'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        return response()->json(['status'=>$room->delete()]);
    }
}
