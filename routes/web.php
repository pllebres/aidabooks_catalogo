<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    // Redirigir a la página de creación de libros si el usuario está autenticado
    if (auth()->check()) {
        return redirect()->route('books.create');
    }
    return view('welcome');
});

// Dashboard protegido por autenticación
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas accesibles sin autenticación
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/scan', function () {
    return view('books.scan');
})->name('books.scan');

// Ruta para escanear, mostrar y guardar el ISBN
Route::middleware(['auth'])->group(function () {
    Route::get('/books/scan-store', [BookController::class, 'scanStore'])->name('books.scan-store'); // Ruta para la vista del formulario scan-store
    Route::post('/books/scan-store', [BookController::class, 'store'])->name('books.scan-store.store'); // Ruta para almacenar los datos
});

// Agrupación de rutas que requieren autenticación
Route::middleware('auth')->group(function () {

    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas protegidas para la gestión de libros
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    // Ruta protegida para obtener información del libro basado en ISBN
    Route::get('/books/fetch-info', [BookController::class, 'fetchBookInfo'])->name('books.fetchInfo');

    Route::get('/test', function () {
        return view('test');
    });

    Route::get('/api/books/check/{isbn}', [BookController::class, 'checkISBN']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/books/manage', [BookController::class, 'manage'])->name('books.manage'); // Ruta para la vista de administración de libros
    Route::patch('/books/{book}/update-copies', [BookController::class, 'updateCopies'])->name('books.update-copies'); // Ruta para actualizar copias
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy'); // Ruta para eliminar libro
});


// dashboard
Route::get('/books/scan', [BookController::class, 'showScan'])->name('books.scan');
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');


// Cargar las rutas de autenticación
require __DIR__.'/auth.php';
