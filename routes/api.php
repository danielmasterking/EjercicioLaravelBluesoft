<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('crear_cuenta', 'CuentaController@CrearCuenta');

Route::post('consignar', 'CuentaController@Consignar');

Route::get('retirar/{numero_cuenta}/{valor}', 'CuentaController@Retirar');

Route::get('consultarSaldo/{numero_cuenta}', 'CuentaController@consultarSaldo');