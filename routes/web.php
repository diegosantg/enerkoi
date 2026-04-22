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
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\ProgresoController;

//RUTAS PUBLICAS
//metodo get
Route::get('/registro',[RegistroController::class,'mostrarFormulario']);
//metodo POST
Route::post('/registro',[RegistroController::class,'registrar']);
//Pantalla de revisa tu bandeja
Route::get('/verificacion-aviso', function(){
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
//Boton del correo
Route::get('/email/verify/{id}/{hash}',function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/completar-perfil');
})->middleware(['auth','signed'])->name('verification.verify');
//Boton para reenviar
Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()-with('mensaje', '¡Enlace enviado!');
})->middleware(['auth','throttle:6,1'])->name('verification.send');

//Rutas ya con el modd o privadas 
Route::middleware(['auth','verified'])->group(function(){

    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::post('/logout',[DashboardController::class,'logout']);

    Route::get('/completar-perfil',[PerfilController::class,'mostrarFormulario']);
    Route::post('/completar-perfil',[PerfilController::class,'guardar']);

    //Rutas de las rutinas
    Route::get('/rutinas',[RutinaController::class,'index']);
    Route::get('/rutinas/crear',[RutinaController::class,'crear']);
    Route::get('/rutina',[RutinaController::class,'guardar']); 
    Route::post('/rutinas',[RutinaController::class,'guardar']);
    Route::get('/api/ejercicios-del-grupo/{id_grupo}',[RutinaController::class,'obtenerEjerciciosPorGrupo']);

    Route::get('/ejercicios', [EjercicioController::class, 'index'])->name('ejercicios.index');
    Route::get('/rutinas/papelera',[RutinaController::class,'papelera'])->name('rutinas.papelera');
    Route::get('/rutinas/{id}',[RutinaController::class, 'show']);
    Route::delete('/rutinas/{id}',[RutinaController::class,'destroy']);
    Route::get('/rutinas/{id}/edit',[RutinaController::class,'edit']);
    Route::put('/rutinas/{id}',[RutinaController::class,'update']);
    Route::post('/rutinas/{id}/restaurar',[RutinaController::class, 'restaurar'])->name('rutinas.restaurar');
    //Rutas de Sesiones de entrenamiento 
    Route::get('/rutinas/{id}/iniciar', [RutinaController::class, 'iniciar']);
    Route::post('/rutinas/{id}/guardar', [RutinaController::class, 'guardarEntrenamiento']);

    //ruta de progreso
    Route::get('/progreso',[ProgresoController::class, 'index'])->name('progreso.index');
});

//Rutas de e login
Route::get('/login',[LoginController::class, 'mostrarFormulario'])->name('login');
Route::post('login',[LoginController::class,'autenticar']);



