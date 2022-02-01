<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Roles\RolController;
use App\Http\Controllers\Publications\PublicationController;
use App\Http\Controllers\Permission\PermissionController;

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
    /** ==== Route Login ==== **/
    Route::get('/', function () {  return Inertia::render('Admin/Login'); })->name('login.close');
    Route::prefix('miblog')->group(function () {
        Route::get('/admin', function () { return Inertia::render('Admin/Login'); });
    });        
    /** ===================== **/

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
    Route::middleware(['auth:sanctum', 'verified'])->get('/roles', function () {
        return Inertia::render('Roles/Index');
    })->name('roles');
    /**===================================**/

    /** METHODS HTTP IN MODULOS **/
    Route::prefix('/dashboard')->group(function () {
        /** ==== Categories ==== **/
        Route::post('table-categories',[CategoryController::Class,'tableCategories'])->name('table.category');
        Route::post('save-categories',[CategoryController::Class,'saveCategories'])->name('save.category');
        Route::delete('/categories/delete/{id}',[CategoryController::Class,'deleteCategories'])->name('delete.category');
        /** ==== Roles ==== **/
        Route::post('table-roles',[RolController::Class,'tableRoles'])->name('table.rol');
        Route::post('save-rol',[RolController::Class,'saveRoles'])->name('save.rol');
        Route::delete('/roles/delete/{id}',[RolController::Class,'deleteRoles'])->name('delete.roles');
        /** ==== Publications ==== **/
        Route::post('get-publications',[PublicationController::Class,'tablePublications'])->name('table.publication');
        Route::get('select/categories',[PublicationController::Class,'selectCategories'])->name('select.category');
        Route::get('create/publication',[PublicationController::Class,'create'])->name('create.publication');
        Route::post('save',[PublicationController::Class,'savePublications'])->name('save.publication');
        Route::get('/edit/{id}', [PublicationController::Class,'edit.publication'])->name('edit.publication');
        Route::get('/detail/publications/{id}', [PublicationController::Class,'detailPublications'])->name('show.detail');
        Route::post('/image/upload', [PublicationController::class, 'uploadImages'])->name('upload.image');
        Route::delete('/delete/publication/{id}',[PublicationController::Class,'deletePublication'])->name('delete.publication');
        
    });
    /**===================================**/

    
    
    
    