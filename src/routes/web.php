<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::namespace('Contrato')->group(function () {
    Route::middleware('carregar-proposta-middleware')->group(function () {
        Route::get('/contrato/{proposta}/create', 'ContratoController@index')->name("Index");
    });
});
