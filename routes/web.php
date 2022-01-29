<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Roles\RolController;
use App\Http\Controllers\Publications\PublicationController;

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
    Route::middleware(['auth:sanctum', 'verified'])->get('/authors', function () {
        return Inertia::render('Users/Index');
    })->name('users');

    /** METHODS HTTP IN MODULO CATEGORIES **/
    Route::prefix('/dashboard')->group(function () {
        Route::post('get-categories',[CategoryController::Class,'allCategories'])->name('allCategory');
    });
    Route::prefix('/dashboard')->group(function () {
        Route::post('save',[CategoryController::Class,'saveCategories'])->name('saveCategory');
    });
    Route::prefix('/dashboard')->group(function () {
        Route::delete('/categories/delete/{id}',[CategoryController::Class,'deleteCategory'])->name('deleteCategory');
    });
    /**===================================**/

    /** METHODS HTTP IN MODULO ROLES **/
    Route::middleware(['auth:sanctum', 'verified'])->get('/roles', function () {
        return Inertia::render('Roles/Index');
    })->name('roles');
    Route::prefix('/dashboard')->group(function () {
        Route::post('get-roles',[RolController::Class,'allRoles'])->name('allRol');
    });
    Route::prefix('/dashboard')->group(function () {
        Route::post('save',[RolController::Class,'saveRoles'])->name('saveRol');
    });
    Route::prefix('/dashboard')->group(function () {
        Route::delete('/roles/delete/{id}',[RolController::Class,'deleteRoles'])->name('deleteCategory');
    });
    /**===================================**/

    /** METHODS HTTP IN MODULO PUBLICATION **/
    Route::prefix('/dashboard')->group(function () {
        Route::post('get-publications',[PublicationController::Class,'allPublications'])->name('allPublication');
    });
    Route::prefix('/dashboard')->group(function () {
        Route::get('select/categories',[PublicationController::Class,'getCategories'])->name('getCategory');
    });
    Route::prefix('/dashboard')->group(function () {
        Route::post('save',[PublicationController::Class,'savePublications'])->name('savePublication');
    });
    Route::prefix('/dashboard')->group(function () {
        Route::post('/image/upload', [PublicationController::class, 'uploadImages'])->name('upload');
    });