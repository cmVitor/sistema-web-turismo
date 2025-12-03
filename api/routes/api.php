<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\HospedagemController;
use App\Http\Controllers\PontoTuristicoController;
use Illuminate\Support\Facades\Route;

//Rotas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/pontos',        [PontoTuristicoController::class, 'index']);
Route::get('/pontos/{id}',   [PontoTuristicoController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    //Aqui as que precisa de authenticação
});
Route::get('/me', [AuthController::class, 'me']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::post('/pontos',              [PontoTuristicoController::class, 'store']);
Route::put('/pontos/{id}',          [PontoTuristicoController::class, 'update']);
Route::delete('/pontos/{id}',       [PontoTuristicoController::class, 'destroy']);

Route::get('/hospedagens',          [HospedagemController::class, 'index']);
Route::post('/hospedagens',         [HospedagemController::class, 'store']);
Route::put('/hospedagens/{id}',     [HospedagemController::class, 'update']);
Route::delete('/hospedagens/{id}',  [HospedagemController::class, 'destroy']);

Route::get('/avaliacoes',          [AvaliacaoController::class, 'index']);
Route::post('/avaliacoes',          [AvaliacaoController::class, 'store']);
Route::put('/avaliacoes/{id}',      [AvaliacaoController::class, 'update']);
Route::delete('/avaliacoes/{id}',   [AvaliacaoController::class, 'destroy']);

Route::middleware('auth:api', 'admin')->group(function () {
    //Aqui as rotas protegidas apenas para admins
    //Pelo q apurei ate o momento será as de atualização e edição de avaliações
});
