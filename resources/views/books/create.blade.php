@extends('layouts.app')
@vite(['resources/css/app.css', 'resources/js/app.js'])


@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <h1 class="text-xl font-bold mb-4">Crear un nuevo libro</h1>

                @if (session('success'))
                    <div style="color: green;">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block font-semibold">Título:</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label for="author" class="block font-semibold">Autor:</label>
                        <input type="text" name="author" id="author" value="{{ old('author') }}" required class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label for="isbn" class="block font-semibold">ISBN:</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
    <label for="publisher" class="block font-semibold">Editorial (Publisher):</label>
    <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" required class="w-full border border-gray-300 rounded p-2">
    @error('publisher')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="published_at" class="block font-semibold">Fecha de publicación</label>
    <input type="date" name="published_at" id="published_at" value="{{ old('published_at') }}" class="w-full border border-gray-300 rounded p-2">
</div>

                    <div class="mb-4">
        <label for="theme" class="block font-semibold">Temática:</label>
        <select name="theme" id="theme" class="w-full border border-gray-300 rounded p-2" required>
            <option value="">Selecciona una temática</option>
            <option value="Literatura">Literatura</option>
            <option value="Comic y Fantasía">Comic y Fantasía</option>
            <option value="Infantil y Juvenil">Infantil y Juvenil</option>
            <option value="Conocimiento y Ciencia">Conocimiento y Ciencia</option>
            <option value="Cocina y Gastronomía">Cocina y Gastronomía</option>
            <option value="Bienestar y Salud">Bienestar y Salud</option>
            <option value="Viajes y Ocio">Viajes y Ocio</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="copies" class="block font-semibold">Cantidad de Ejemplares:</label>
        <input type="number" name="copies" id="copies" value="{{ old('copies', 1) }}" min="1" class="w-full border border-gray-300 rounded p-2">
    </div>

    <div class="mb-4">
    <label for="cover" class="block font-semibold">URL de la Portada</label>
    <input type="text" name="cover" id="cover" value="{{ old('cover') }}" class="w-full border border-gray-300 rounded p-2">
</div>

                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded">Guardar Libro</button>
                </form>

            </div>
        </div>
    </div>
@endsection
