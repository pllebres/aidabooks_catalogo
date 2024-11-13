<!-- resources/views/books/search_results.blade.php -->

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
    <h1 class="text-2xl font-bold mb-4">Resultados de la Búsqueda</h1>

    @if($books->isEmpty())
        <p>No se encontraron libros que coincidan con los criterios de búsqueda.</p>
    @else
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Portada</th>
                    <th class="px-4 py-2 border">Título</th>
                    <th class="px-4 py-2 border">Autor</th>
                    <th class="px-4 py-2 border">Editorial</th>
                    <th class="px-4 py-2 border">Temática</th>
                    <th class="px-4 py-2 border">ISBN</th>
                    
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
                        <td class="px-4 py-2 border">{{ $book->isbn }}</td>
                     
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
