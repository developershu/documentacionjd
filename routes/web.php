<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;


// Rutas Públicas
Route::redirect('/', '/login'); 


// Rutas de Autenticación
Route::middleware('guest')->group(function () {
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['web'])->group(function () {
    Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Rutas para el Perfil (GET para ver, PUT para actualizar)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('documentos', DocumentoController::class)->except(['show']);
    Route::get('documentos/{documento}', [DocumentoController::class, 'show'])->name('documentos.show');

    // Rutas para Categorías
    
    Route::resource('categorias', CategoriaController::class);

    //rutas para comentarios    
    Route::post('/documentos/{documento}/toggle-comentarios', [DocumentoController::class, 'toggleComentarios'])->name('documentos.toggle-comentarios');
    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');
});


