<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\WPostController;
use App\Http\Controllers\dashboard\PostController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\SettingController;
use App\Http\Controllers\Website\WCategoryController;
use App\Http\Controllers\dashboard\CategoryController;


Route::get('/', function () {
    return view('dashboard.index');
})->middleware('checkuser');


//________________________________website __________________________________________
route::get('website/index', [IndexController::class, 'index'])->name('website');
Route::get('/categories/{category}', [WCategoryController::class, 'show'])->name('category');
Route::get('/post/{post}', [WPostController::class, 'show'])->name('post');




//
route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    //index dashboard
    route::get('index', function () {
        return view('dashboard.index');
    })->name('index')->middleware('checkuser');

    //____________________________Setting__________________________________________

    // update setting
    route::post('settings/update/{settings}', [SettingController::class, 'update'])->name('settings.update')->middleware('checkuser');
    // setting
    route::get('settings', [SettingController::class, 'index'])->name('settings')->middleware('auth', 'CheckLogin')->middleware('checkuser');

    //_______________________________User____________________________________________
    Route::resource('users', UserController::class)->middleware('checkuser');
    Route::get('dashboard/users/all', [UserController::class, 'getallusers'])->name('users.all')->middleware('checkuser');
    Route::post('users/delete', [UserController::class, 'delete'])->name('users.delete')->middleware('checkuser');
    //________________________________Category __________________________________________
    Route::resource('Category', CategoryController::class)->middleware('checkuser');
    Route::get('/category/all', [CategoryController::class, 'getCategoriesDatatable'])->name('category.all')->middleware('checkuser');
    Route::post('/category/delete', [CategoryController::class, 'delete'])->name('category.delete')->middleware('checkuser');
    //________________________________Category __________________________________________
    Route::resource('posts', PostController::class)->middleware('checkuser');
    Route::get('dashboard/posts/all', [PostController::class, 'getPostsDatatable'])->name('posts.all')->middleware('checkuser');
    Route::post('/posts/delete', [PostController::class, 'delete'])->name('posts.delete')->middleware('checkuser');
})->middleware('checkuser');

// ui
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// logout

Route::group(['middleware' => ['auth']], function () {
    /**
     * Logout Route
     */
    Route::get('/logout', [SettingController::class, 'logout'])->name('logout');
})->middleware('checkuser');
