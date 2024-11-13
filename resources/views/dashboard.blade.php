@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <!-- Título principal -->
    <div class="flex flex-col items-center">
        <h1 class="text-lg font-bold mb-4">¿BUSCAS UN LIBRO?</h1>
    </div>

    <!-- Formulario de Búsqueda -->
    <form id="search-form" action="{{ route('books.search') }}" method="GET" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <!-- Campo ISBN -->
        <div class="mb-4 relative">
            <label for="isbn" class="sr-only">ISBN</label>
            <input type="text" id="isbn" name="isbn" placeholder="ISBN" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <span class="absolute right-3 top-2 text-gray-500">
                <i class="fas fa-camera"></i>
            </span>
        </div>

        <!-- Campo Título -->
        <div class="mb-4 relative">
            <label for="title" class="sr-only">Título</label>
            <input type="text" id="title" name="title" placeholder="Título" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <span class="absolute right-3 top-2 text-gray-500">
                <i class="fas fa-search"></i>
            </span>
        </div>

        <!-- Campo Autor -->
        <div class="mb-4 relative">
            <label for="author" class="sr-only">Autor/a</label>
            <input type="text" id="author" name="author" placeholder="Autor/a" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <span class="absolute right-3 top-2 text-gray-500">
                <i class="fas fa-search"></i>
            </span>
        </div>

        <!-- Campo Temática -->
        <div class="mb-4 relative">
            <label for="theme" class="sr-only">Temática</label>
            <select id="theme" name="theme" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Temática</option>
                <option value="Literatura">Literatura</option>
                <option value="Comic y Fantasía">Comic y Fantasía</option>
                <option value="Infantil y Juvenil">Infantil y Juvenil</option>
                <option value="Conocimiento y Ciencia">Conocimiento y Ciencia</option>
                <option value="Cocina y Gastronomía">Cocina y Gastronomía</option>
                <option value="Bienestar y Salud">Bienestar y Salud</option>
                <option value="Viajes y Ocio">Viajes y Ocio</option>
            </select>
            <span class="absolute right-3 top-2 text-gray-500">
                <i class="fas fa-chevron-down"></i>
            </span>
        </div>

        <!-- Botón de Búsqueda -->
        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline">
            Buscar
        </button>
    </form>
</div>

<!-- JavaScript para Redirección Condicional -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isbnInput = document.getElementById('isbn');

        // Redirigir a books/scan al seleccionar el campo ISBN
        isbnInput.addEventListener('focus', function() {
            window.location.href = "{{ route('books.scan') }}";
        });
    });
</script>
@endsection
