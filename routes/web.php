<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::put("/users/{id}",[Usercontroller::class,'update'])->name('users.update');
Route::get("/users/{id}/edit",[Usercontroller::class,'edit'])->name('users.edit');
Route::get("/users",[Usercontroller::class,'index'])->name('users.index');
Route::get("/users/create",[Usercontroller::class,'create'])->name('users.create');
Route::post("/users",[Usercontroller::class,'store'])->name('users.store');
Route::get("/users/{id}",[Usercontroller::class,'show'])->name('users.show');

