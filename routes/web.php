<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CopiaController;
use App\Http\Controllers\PrenotazioneController;
use Illuminate\Support\Facades\Route;

use Picqer\Barcode\BarcodeGeneratorPNG;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/barcode/{code}', function ($code) {
    $generator = new BarcodeGeneratorPNG();
    return response($generator->getBarcode($code, $generator::TYPE_CODE_128))
        ->header('Content-type', 'image/png');
})->name('barcode.generate');


/**
 * Route::get('/dashboard', function () {
 *  return view('dashboard');
 * })->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/prenotazioni', [PrenotazioneController::class, 'indexAdmin'])->name('prenotazioni.admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/libri', LibroController::class)->parameters(['libri' => 'libro']);


    Route::get('/categorie', [CategoriaController::class, 'index'])->name('categorie');
    Route::get('/categorie/create', [CategoriaController::class, 'create'])->name('categorie.createCategoria');
    Route::post('/categorie', [CategoriaController::class, 'store'])->name('categorie.storeCategoria');

    Route::get('/categorie/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorie.editCategoria');
    Route::put('/categorie/{categoria}', [CategoriaController::class, 'update'])->name('categorie.saveCategoria');
    Route::delete('/categorie/{categoria}', [CategoriaController::class, 'destroy'])->name('categorie.destroyCategoria');

    Route::get('/categorie/{categoria}/libri', [CategoriaController::class, 'showLibri'])->name('categorie.libri');
    Route::get('/categorie/{id}/libri', [CategoriaController::class, 'libri'])->name('categorie.libri');

    //Percorsi nidificati: copia appartenente a un libro
    Route::prefix('libri/{libro}')->group(function () {
        
        Route::get('copie/create', [CopiaController::class, 'create'])->name('copie.create');
        Route::post('copie', [CopiaController::class, 'store'])->name('copie.store');
        Route::get('copie', [CopiaController::class, 'index'])->name('copie.index');
        Route::get('copie/disponibili', [CopiaController::class, 'listaDisponibili'])->name('copie.listaDisponibili');

    });
    //Percorsi non nidificati per mostrare, modificare, eliminare o copiare
    Route::get('copie/{id}', [CopiaController::class, 'show'])->name('copie.show');
    Route::post('/copie/disponibili', [CopiaController::class, 'disponibiliAjax'])->name('copie.disponibili');

    Route::get('copie/{copia}', [CopiaController::class, 'show'])->name('copie.show');
    Route::get('copie/{copia}/edit', [CopiaController::class, 'edit'])->name('copie.edit');
    Route::put('copie/{copia}', [CopiaController::class, 'update'])->name('copie.update');
    Route::delete('copie/{copia}', [CopiaController::class, 'destroy'])->name('copie.destroy');

   
    Route::get('/prenotazioni/create', [PrenotazioneController::class, 'create'])->name('prenotazioni.create');
    Route::get('/prenotazioni/utente', [PrenotazioneController::class, 'userList'])->name('prenotazioni.user_list');
    Route::post('/prenotazioni', [PrenotazioneController::class, 'store'])->name('prenotazioni.store');
    Route::get('/prenotazioni/store-and-redirect', [PrenotazioneController::class, 'storeAndRedirect'])
     ->name('prenotazioni.storeAndRedirect');
      Route::get('/prenotazioni', [PrenotazioneController::class, 'index'])->name('prenotazioni.index');

    
});


    






require __DIR__ . '/auth.php';