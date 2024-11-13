{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Bienvenido a la Biblioteca</h1>
            <p class="mb-4">Aquí puedes explorar el catálogo de libros o escanear un libro por su ISBN.</p>

            <!-- Botón para ver el catálogo -->
            <a href="{{ route('books.index') }}" class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded mb-4 hover:bg-blue-600">
                Ver Catálogo de Libros
            </a>

            <!-- Botón para escanear un libro -->
            <a href="{{ route('books.scan') }}" class="inline-block bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600">
                Escanear un Libro
            </a>

            <!-- Si el usuario está autenticado, mostrar el enlace para crear un libro -->
            @auth
                <a href="{{ route('books.create') }}" class="inline-block bg-gray-500 text-white font-semibold py-2 px-4 rounded mt-4 hover:bg-gray-600">
                    Crear un Libro
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
