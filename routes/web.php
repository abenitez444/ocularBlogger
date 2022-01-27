<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|w
*/

    Route::get('/', function () {  return Inertia::render('Admin/Login'); })->name('login.close');

    Route::prefix('miblog')->group(function () {
        Route::get('/admin', function () { return Inertia::render('Admin/Login'); });
    });        
    /** Protection in routes for sanctum **/   
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::middleware(['auth:sanctum', 'verified'])->get('/categories', function () {
        return Inertia::render('Categories/Index');
    })->name('categories');

    Route::middleware(['auth:sanctum', 'verified'])->get('/publications', function () {
        return Inertia::render('Publications/Index');
    })->name('publications');
