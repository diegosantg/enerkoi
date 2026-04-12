<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RutinaController;
use App\Models\Perfil;
use App\Models\Rutina;
use Illuminate\Support\Facades\Auth;

//RUTAS PUBLICAS
//metodo get
Route::get('/registro',[RegistroController::class,'mostrarFormulario']);
//metodo POST
Route::post('/registro',[RegistroController::class,'registrar']);

//Rutas ya con el modd o privadas 
Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::post('/logout',[DashboardController::class,'logout']);

    Route::get('/completar-perfil',[PerfilController::class,'mostrarFormulario']);
    Route::post('/completar-perfil',[PerfilController::class,'guardar']);

    //Rutas de las rutinas jkajdkadka rutasRutinas
    Route::get('/rutinas',[RutinaController::class,'index']);
    Route::get('/rutinas/crear',[RutinaController::class,'crear']);
    Route::get('/rutina',[RutinaController::class,'guardar']);
    Route::post('/rutinas',[RutinaController::class,'guardar']);
    Route::get('/api/ejercicios-del-grupo/{id_grupo}',[RutinaController::class,'obtenerEjerciciosPorGrupo']);
//ruta del sh9w
    Route::get('/rutinas/{id}',[RutinaController::class, 'show']);
//ruta pa mandar a la papelera
    Route::delete('/rutinas/{id}',[RutinaController::class,'destroy']);

    Route::get('/rutinas/{id}/edit',[RutinaController::class,'edit']);
    Route::put('/rutinas/{id}',[RutinaController::class,'update']);

    Route::get('/papelera',[RutinaController::class,'papelera']);
    Route::post('/rutinas/{id}/restaurar',[RutinaController::class]);
});

//Rutas de e login
Route::get('/login',[LoginController::class, 'mostrarFormulario'])->name('login');
Route::post('login',[LoginController::class,'autenticar']);



