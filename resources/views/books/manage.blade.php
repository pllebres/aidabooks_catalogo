@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Administración de Libros</h1>


             <!-- Formulario de búsqueda -->
             <form action="{{ route('books.manage') }}" method="GET" class="mb-4">
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-4">
                        <label for="title" class="block font-semibold">Título</label>
                        <input type="text" name="title" id="title" value="{{ request('title') }}" class="w-full border border-gray-300 rounded p-2">
                    </div>
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-4">
                        <label for="author" class="block font-semibold">Autor</label>
                        <input type="text" name="author" id="author" value="{{ request('author') }}" class="w-full border border-gray-300 rounded p-2">
                    </div>
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-4">
                        <label for="isbn" class="block font-semibold">ISBN</label>
                        <input type="text" name="isbn" id="isbn" value="{{ request('isbn') }}" class="w-full border border-gray-300 rounded p-2">
                    </div>
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-4">
                        <label for="theme" class="block font-semibold">Temática</label>
                        <select name="theme" id="theme" class="w-full border border-gray-300 rounded p-2">
                            <option value="">Todas</option>
                            <option value="Literatura" {{ request('theme') == 'Literatura' ? 'selected' : '' }}>Literatura</option>
                            <option value="Comic y Fantasía" {{ request('theme') == 'Comic y Fantasía' ? 'selected' : '' }}>Comic y Fantasía</option>
                            <option value="Infantil y Juvenil" {{ request('theme') == 'Infantil y Juvenil' ? 'selected' : '' }}>Infantil y Juvenil</option>
                            <option value="Conocimiento y Ciencia" {{ request('theme') == 'Conocimiento y Ciencia' ? 'selected' : '' }}>Conocimiento y Ciencia</option>
                            <option value="Cocina y Gastronomía" {{ request('theme') == 'Cocina y Gastronomía' ? 'selected' : '' }}>Cocina y Gastronomía</option>
                            <option value="Bienestar y Salud" {{ request('theme') == 'Bienestar y Salud' ? 'selected' : '' }}>Bienestar y Salud</option>
                            <option value="Viajes y Ocio" {{ request('theme') == 'Viajes y Ocio' ? 'selected' : '' }}>Viajes y Ocio</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded">Buscar</button>
            </form>

            <!-- Mostrar mensajes de éxito -->
            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabla de libros -->
            <table class="min-w-full border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Portada</th>
                        <th class="px-4 py-2 border">Título</th>
                        <th class="px-4 py-2 border">Autor</th>
                        <th class="px-4 py-2 border">Editorial</th>
                        <th class="px-4 py-2 border">Temática</th>
                        <th class="px-4 py-2 border">Cantidad de Copias</th>
                        <th class="px-4 py-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td class="px-4 py-2 border">
                                @if ($book->cover)
                                    <img src="{{ $book->cover }}" alt="Portada" style="max-width: 50px;">
                                @endif
                            </td>
                            <td class="px-4 py-2 border">{{ $book->title }}</td>
                            <td class="px-4 py-2 border">{{ $book->author }}</td>
                            <td class="px-4 py-2 border">{{ $book->publisher }}</td>
                            <td class="px-4 py-2 border">{{ $book->theme }}</td>
                            <td class="px-4 py-2 border">
                                <form action="{{ route('books.update-copies', $book) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="copies" value="{{ $book->copies }}" min="1" class="w-16 border border-gray-300 rounded p-1">
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Actualizar</button>
                                </form>
                            </td>
                            <td class="px-4 py-2 border">
                                <!-- Botón para eliminar el libro -->
                                <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este libro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
