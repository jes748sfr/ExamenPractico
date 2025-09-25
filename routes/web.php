<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/companies', [CompanyController::class, 'index']);
Route::post('/companies/create', [CompanyController::class, 'store']);
Route::patch('/companies/edit/{id}', [CompanyController::class, 'update']);
Route::delete('/companies/delete/{id}', [CompanyController::class, 'delete']);

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks/create', [TaskController::class, 'store']);
Route::patch('/tasks/edit/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/delete/{id}', [TaskController::class, 'delete']);

require __DIR__.'/auth.php';
