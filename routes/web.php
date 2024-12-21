<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ImageController;


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
    
    Route::get('/adminDashboard', [FolderController::class, 'index'])->name('dashboard');
    Route::post('/folders', [FolderController::class, 'store']);
    Route::delete('/folders/{folder}', [FolderController::class, 'destroy']);
Route::post('/images', [ImageController::class, 'store']);


Route::post('/images', [ImageController::class, 'storeImage'])->name('images.store');



Route::get('/images/download/{image}', [ImageController::class, 'download'])->name('images.download');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
