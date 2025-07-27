<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/libri', LibroController::class);

    Route::get('/categorie', [CategoriaController::class, 'index'])->name('categorie');
    Route::get('/categorie/create', [CategoriaController::class, 'create'])->name('categorie.createCategoria');
    Route::post('/categorie', [CategoriaController::class, 'store'])->name('categorie.storeCategoria');

    Route::get('/categorie/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorie.editCategoria');
    Route::put('/categorie/{categoria}', [CategoriaController::class, 'update'])->name('categorie.saveCategoria');
    Route::delete('/categorie/{categoria}', [CategoriaController::class, 'destroy'])->name('categorie.destroyCategoria');

    Route::get('/categorie/{categoria}/libri', [CategoriaController::class, 'showLibri'])->name('categorie.libri');
});



require __DIR__ . '/auth.php';
