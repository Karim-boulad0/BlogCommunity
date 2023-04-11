<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\CategoryAdminController;
use App\Http\Controllers\API\LoginController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
route::get('/', function () {
    return 1;
});
route::get('settings', [SettingController::class, 'index'])->middleware('auth:sanctum');
route::get('categories', [CategoriesController::class, 'index']);
route::get('categories_with_posts', [CategoriesController::class, 'categories_with_posts']);
route::post('login', [LoginController::class, 'login']);
route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
route::apiresource('categoryadmin', CategoryAdminController::class)->except('index', 'show')->middleware('auth:sanctum');
