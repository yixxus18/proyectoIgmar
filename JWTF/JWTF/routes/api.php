<?php

use App\Mail\ValidatorEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriasController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login'])->middleware('auth.active');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::get('activate/{user}', 'App\Http\Controllers\AuthController@activate')->name('activate')->middleware('signed');

    Route::get('get',[UserController::class,'index']);
    Route::post('post',[UserController::class,'store'])->middleware('authrole2');
    Route::delete('delete/{id}',[UserController::class,'destroy'])->middleware('authrole')->where('id','[0-9]+');
    Route::put('put/{id}',[UserController::class,'update'])->middleware('authrole2')->where('id','[0-9]+');

    Route::post('verificar', [AuthController::class,'verificarcodigo']);
    Route::post('verify', [AuthController::class,'verify']);

    Route::get('getcategoria',[CategoriasController::class,'index']);
    Route::post('storecategoria',[CategoriasController::class,'store']);
    Route::put('editarcategoria/{id}',[CategoriasController::class,'update'])->where('id','[0-9]+');
    Route::delete('eliminarcategoria/{id}',[CategoriasController::class,'delete'])->where('id','[0-9]+');



});



