<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('index');
});

//Recurso para funcione de crud
Route::resource('/index', TaskController::class)->middleware('auth');

//Completado de tareas
Route::get('/check/{task}', [TaskController::class, 'checkTask'])->middleware('auth');

//rutas para manejo de usuarios
Route::get('/login', [UserController::class, 'index'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'storage'])->name('register');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

