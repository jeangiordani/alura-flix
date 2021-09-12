<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {


    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post("/login", [AuthController::class, 'login'])->name('auth.login');
    Route::post("/logout", [AuthController::class, 'logout'])->name('auth.logout');
    Route::post("/me", [AuthController::class, 'me'])->name('auth.me');
});

Route::get('/categorias', [CategoryController::class, 'getCategories'])->name('get.categories')->middleware('jwt.auth');
Route::get('/categorias/{id}', [CategoryController::class, 'getCategory'])->name('get.category')->middleware('jwt.auth');
Route::post('/categorias', [CategoryController::class, 'createCategory'])->name('post.category')->middleware('jwt.auth');
Route::put('/categorias/{id}', [CategoryController::class, 'updateCategory'])->name('put.category')->middleware('jwt.auth');
Route::delete('/categorias/{id}', [CategoryController::class, 'destroyCategory'])->name('delete.category')->middleware('jwt.auth');

Route::get('/videos', [VideoController::class, 'getVideos'])->name('get.videos')->middleware('jwt.auth');
Route::post('/videos', [VideoController::class, 'createVideo'])->name('post.video')->middleware('jwt.auth');
Route::get('/videos/{id}', [VideoController::class, 'getVideo'])->name('get.video')->middleware('jwt.auth');
Route::put('/videos/{id}', [VideoController::class, 'updateVideo'])->name('update.video')->middleware('jwt.auth');
Route::delete('/videos/{id}', [VideoController::class, 'destroyVideo'])->name('delete.video')->middleware('jwt.auth');
