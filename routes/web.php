<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Show Login Form


Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::middleware(['auth', 'role:super_admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('/utilisateur', function(){
        return view('super_admin.utilisateur');
    });

    Route::get('/userData', [UserController::class, 'getData'])->name('user_data');
    Route::put('/activate/{id}', [UserController::class, 'activateAdmin'])->name('activate');

    // Show Register/Create Form
    Route::get('register', [UserController::class, 'create']);
    
    // Create New User
    Route::post('users', [UserController::class, 'store']);

    // Delete User
    Route::delete('/deleteuser/{id}', [UserController::class, 'deleteUser']);

    Route::get('/', function () {
        return redirect('/dashboard');    
    });

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::group(['role' => 'admin'], function () {

        Route::get('/admin/home',[AdminController::class,'adminHome'])->name('admin_home');

        // rooms
        Route::get('/admin/rooms',[RoomController::class,'index'])->name('admin.rooms');
        Route::get('/admin/fetchRooms',[RoomController::class,'fetchRooms'])->name('admin.fetchRooms');
        Route::post('/admin/rooms',[RoomController::class,'store'])->name('admin.rooms.store');
        Route::delete('/admin/rooms/{room}',[RoomController::class,'destroy'])->name('admin.rooms.destroy');
        Route::put('/admin/rooms/{room}',[RoomController::class,'update'])->name('admin.rooms.update');
        
        // machines
        Route::get('/admin/machines',[MachineController::class,'index'])->name('admin.machines');
        Route::get('/admin/fetchMachines',[MachineController::class,'fetchMachines'])->name('admin.fetchMachines');
        Route::get('/admin/fetchMachinesPerRooms/{room_id}',[MachineController::class,'fetchMachinesPerRooms'])->name('admin.fetchMachinesPerRooms');
        Route::post('/admin/machines',[MachineController::class,'store'])->name('admin.machines.store');
        Route::delete('/admin/machines/{machine}',[MachineController::class,'destroy'])->name('admin.machines.destroy');
        Route::put('/admin/machines/{machine}',[MachineController::class,'update'])->name('admin.machines.update');
        Route::get('/admin/statistiques',[AdminController::class,'getStatistics'])->name('admin.statistiques');
        Route::get('/admin/machinesPerRooms',[MachineController::class,'listMachinesPerRooms'])->name('admin.machinesPerRooms');

        Route::get('/admin', function () {
            return redirect('/admin/home');    
        });

        Route::get('/', function () {
            return redirect('/admin/home');    
        });

    });
});


