<?php

use App\Http\Controllers\PedidosController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//Grupo para rutas protegidas
Route::middleware('auth:sanctum')->group(function(){

    Route::get('/user', function(Request $request){
        return $request->user();
    });

    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/usuarios/{inicial}',[UserController::class, 'buscarInicial']);
    Route::get('/usuarios/pedidos/{userId}',[UserController::class, 'registrosXusuario']);


    Route::get('/pedidos/desc', [PedidosController::class, 'pedidosDescendente']);
    Route::get('/pedidos/agrupados', [PedidosController::class, 'agrupadoXusuario']);
    Route::get('/pedidos/sum', [PedidosController::class, 'sumaTotal']);
    Route::get('/pedidos/min', [PedidosController::class, 'pedidoMenor']); 
    Route::post('/pedidos/rango', [PedidosController::class, 'buscarRango']);
    Route::get('/pedidos',[PedidosController::class, 'index']);
    Route::post('/pedidos',[PedidosController::class, 'store']);
    Route::get('/pedidos/{id}',[PedidosController::class, 'pedidosId']);

});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

