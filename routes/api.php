<?php

use App\Http\Controllers\InvitacionController;
use App\Http\Controllers\ListaCancionController;
use App\Http\Controllers\ListaReproduccionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ["auth:sanctum"]], function ()
{
    
    Route::controller(UserController::class)->group(function () {
        Route::get('auth/user-profile', 'userProfile');
        Route::post('auth/logout',  'logout');
        Route::get('auth/mostrar-usuarios', 'index');
    });


    Route::controller(ListaReproduccionController::class)->group(function () {
        Route::get('auth/verLista', 'index');
        Route::post('auth/guardarLista','store');
        Route::delete('auth/eliminarLista/{id}','destroy');
    });

    Route::controller(InvitacionController::class)->group(function () {
        Route::get('auth/invitacionesRecibidas', 'index');
        Route::get('auth/invitacionesEnviadas', 'enviadas');
        Route::post('auth/crearInvitacion','store');
        Route::delete('auth/eliminarInvitacion/{id}','destroy');
        Route::put('auth/editarInvitacion/{id}','update');
    });
    
   
});
Route::post('auth/login', [UserController::class, 'login']);
Route::post('auth/register', [UserController::class, 'register']);



