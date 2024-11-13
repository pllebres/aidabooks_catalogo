<!-- resources/views/books/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">¿Buscas un Libro?</h1>

        <!-- Formulario de Búsqueda -->
        <form method="GET" action="{{ route('books.index') }}" class="mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex flex-col">
                    <label for="title" class="text-gray-700 font-semibold">Título</label>
                    <input type="text" name="title" id="title" value="{{ request('title') }}" class="border border-gray-300 rounded p-2" placeholder="Buscar por título">
                </div>

                <div class="flex flex-col">
                    <label for="author" class="text-gray-700 font-semibold">Autor</label>
                    <input type="text" name="author" id="author" value="{{ request('author') }}" class="border border-gray-300 rounded p-2" placeholder="Buscar por autor">
                </div>

                <div class="flex flex-col">
                    <label for="isbn" class="text-gray-700 font-semibold">ISBN</label>
                    <input type="text" name="isbn" id="isbn" value="{{ request('isbn') }}" class="border border-gray-300 rounded p-2" placeholder="Buscar por ISBN">
                </div>

    
     <div class="flex flex-col">
            <label for="theme" class="text-gray-700 font-semibold">Temática</label>
            <select name="theme" id="theme" class="border border-gray-300 rounded p-2">
                <option value="">Selecciona una temática</option>
                <option value="Literatura" {{ request('theme') == 'Literatura' ? 'selected' : '' }}>Literatura</option>
                <option value="Comic y Fantasía" {{ request('theme') == 'Comic y Fantasía' ? 'selected' : '' }}>Comic y Fantasía</option>
                <option value="Infantil y Juvenil" {{ request('theme') == 'Infantil y Juvenil' ? 'selected' : '' }}>Infantil y Juvenil</option>
                <option value="Conocimiento y Ciencia" {{ request('theme') == 'Conocimiento y Ciencia' ? 'selected' : '' }}>Conocimiento y Ciencia</option>
                <option value="Cocina y Gastronomía" {{ request('theme') == 'Cocina y Gastronomía' ? 'selected' : '' }}>Cocina y Gastronomía</option>
                <option value="Bienestar y Salud" {{ request('theme') == 'Bienestar y Salud' ? 'selected' : '' }}>Bienestar y Salud</option>
                <option value="Viajes y Ocio" {{ request('theme') == 'Viajes y Ocio' ? 'selected' : '' }}>Viajes y Ocio</option>
            </select>
        </div>

                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Tabla de Libros -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 p-2">ID</th>
                    <th class="border border-gray-300 p-2">Título</th>
                    <th class="border border-gray-300 p-2">Autor</th>
                    <th class="border border-gray-300 p-2">Año de Publicación</th>
                    <th class="border border-gray-300 p-2">Temática</th> 
                     <th class="border border-gray-300 p-2">Cantidad de Ejemplares</th> 
                    <th class="border border-gray-300 p-2">Portada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $book->id }}</td>
                        <td class="border border-gray-300 p-2">{{ $book->title }}</td>
                        <td class="border border-gray-300 p-2">{{ $book->author }}</td>
                        <td class="border border-gray-300 p-2">{{ $book->published_at }}</td>
                        <td class="border border-gray-300 p-2">{{ $book->theme }}</td>
                        <td class="border border-gray-300 p-2">{{ $book->copies }}</td> 
                        <td class="border border-gray-300 p-2">
                            @if($book->cover)
                                <img src="{{ $book->cover }}" alt="Portada de {{ $book->title }}" class="h-16 w-auto">
                            @else
                                Sin portada
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
