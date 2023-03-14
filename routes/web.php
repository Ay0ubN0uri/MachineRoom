<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
// Route::get('/register', [UserController::class, 'login'])->name('register')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Route::get('/reset_password', [UserController::class, 'resetPassword']);

Route::post('/password/reset', [UserController::class, 'resetPassword']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::group(['role' => 'admin'], function () {
        Route::get('/admin/home', function () {
            return view('admin.dashboard');
        });
    });
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('super_admin.dashboard');
    });

    Route::get('/', function () {
        return redirect('/dashboard');    
    });
    
    Route::get('/utilisateur', function(){
        return view('super_admin.utilisateur');
    });

    Route::get('/userData', [UserController::class, 'getData'])->name('user_data');
    Route::put('/activate/{id}', [UserController::class, 'activateAdmin'])->name('activate');

    // Show Register/Create Form
    Route::get('register', [UserController::class, 'create']);
    
    // Create New User
    Route::post('users', [UserController::class, 'store']);

});
