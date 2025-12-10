<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\HospedagemController;
use App\Http\Controllers\PontoTuristicoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Rotas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/pontos',        [PontoTuristicoController::class, 'index']);
Route::get('/pontos/{id}',   [PontoTuristicoController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    Route::post('/favoritos', [FavoritoController::class, 'store']);
    Route::delete('/favoritos/{id}', [FavoritoController::class, 'destroy']);
    Route::post('/pontos', [PontoTuristicoController::class, 'store']);
    Route::post('/avaliacoes',          [AvaliacaoController::class, 'store']);
});
Route::get('/me', [AuthController::class, 'me']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::get('/usuarios', [UserController::class, 'index']);
Route::put('/usuarios/{id}', [UserController::class, 'update']);        
Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);

Route::post('/pontos',              [PontoTuristicoController::class, 'store']);
Route::put('/pontos/{id}',          [PontoTuristicoController::class, 'update']);
Route::delete('/pontos/{id}',       [PontoTuristicoController::class, 'destroy']);

Route::get('/hospedagens',          [HospedagemController::class, 'index']);
Route::post('/hospedagens',         [HospedagemController::class, 'store']);
Route::put('/hospedagens/{id}',     [HospedagemController::class, 'update']);
Route::delete('/hospedagens/{id}',  [HospedagemController::class, 'destroy']);

Route::get('/avaliacoes',          [AvaliacaoController::class, 'index']);
Route::put('/avaliacoes/{id}',      [AvaliacaoController::class, 'update']);
Route::delete('/avaliacoes/{id}',   [AvaliacaoController::class, 'destroy']);

Route::get('/favoritos/{usuario_id}', [FavoritoController::class, 'listByUser']);

Route::get('/pontos/{id}/hospedagens',[HospedagemController::class, 'listarPorPonto']);
Route::get('/pontos/mais-acessados',[PontoTuristicoController::class, 'maisAcessados']);

Route::get('/pontos/{id}/comentarios', [ComentarioController::class, 'index']);
Route::post('/pontos/{id}/comentarios', [ComentarioController::class, 'store']);

Route::middleware('auth:api', 'admin')->group(function () {
    //Aqui as rotas protegidas apenas para admins
    //Pelo q apurei ate o momento será as de atualização e edição de avaliações
});
