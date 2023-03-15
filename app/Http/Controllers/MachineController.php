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

    public function store(Request $request)
    {
        $machine = new Machine();
        $machine->reference = $request->reference;
        $machine->brand = $request->brand;
        $machine->price = $request->price;
        $machine->purchaseDate = $request->purchaseDate;
        $machine->room_id = $request->room_id;
        $machine->save();
        return response()->json(['status'=>true]);
    }

    public function update(Request $request, Machine $machine )
    {
        $machine->fill([
            'reference' =>$request->reference,
            'brand' =>$request->brand,
            'price' =>$request->price,
            'purchaseDate' =>$request->purchaseDate,
            'room_id' =>$request->room_id,
        ]);
        $machine->save();
        return response()->json(['status'=>true]);
    }

    public function destroy(Machine $machine)
    {
        return response()->json(['status'=>$machine->delete()]);
    }

    public function listMachinesPerRooms(){
        return view('admin.listMachinesPerRooms');
    }

    public function fetchMachinesPerRooms($room_id){
        $data = Machine::where('room_id', $room_id)->get();
        return response()->json(['data' => $data]);
    }
}
