<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Crear una consulta base para el modelo Book
        $query = Book::query();

        // Aplicar filtros según los parámetros de búsqueda recibidos
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        if ($request->filled('isbn')) {
            $query->where('isbn', 'like', '%' . $request->isbn . '%');
        }

    if ($request->filled('theme')) {
        $query->where('theme', $request->theme);
    }


        // Obtener los resultados de la consulta con paginación
        $books = $query->paginate(10); // Puedes ajustar el número de resultados por página

        // Retornar la vista y pasar los datos de los libros
        return view('books.index', compact('books'));
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        return view('books.create'); // Asegúrate de que esta vista exista en resources/views/books/create.blade.php
    }
    
    public function fetchBookInfo(Request $request)
    {
        $isbn = $request->query('isbn');
        $book = Book::where('isbn', $isbn)->first();

        // Verificar que el ISBN esté presente
        if (!$isbn) {
            return response()->json(['error' => 'No se proporcionó ningún ISBN.'], 400);
        }

        // Llamar a la API de Open Library
        try {
            $response = Http::get("https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&format=json&jscmd=data");

            // Verificar si la llamada falló
            if ($response->failed()) {
                return response()->json(['error' => 'Error al conectar con la API de Open Library.'], 500);
            }

            $data = $response->json();
            $bookKey = "ISBN:$isbn";

            // Verificar si el libro existe en la respuesta
            if (!isset($data[$bookKey])) {
                return response()->json(['error' => 'No se encontró información para este ISBN.'], 404);
            }

            // Extraer y formatear la información del libro
            $bookInfo = $data[$bookKey];

            return response()->json([
                'title' => $book->title,
                'author' => $book->author,
                'publisher' => $book->publisher,
                'published_at' => $book->published_at,
                'cover' => $book->cover,
                'theme' => $book->theme,
                'copies' => $book->copies,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un problema al obtener la información del libro: ' . $e->getMessage()], 500);
        }
    }

    public function scanStore()
    {
        return view('books.scan-store');
    }

   public function store(Request $request)
{
    \Log::info('Iniciando el guardado de libro');

    // Validación de los datos del formulario
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'isbn' => 'required|string|max:13',
        'publisher' => 'required|string|max:255',
        'published_at' => 'nullable|date',
        'cover' => 'nullable|url',
        'theme' => 'required|string|in:Literatura,Comic y Fantasía,Infantil y Juvenil,Conocimiento y Ciencia,Cocina y Gastronomía,Bienestar y Salud,Viajes y Ocio',
        'copies' => 'required|integer|min:1',
    ], [
        // Mensaje de error personalizado para el campo ISBN
        'isbn.unique' => 'Este libro ya está registrado en el sistema.'
    ]);

    \Log::info('Datos validados correctamente', $validatedData);

    // Buscar si ya existe un libro con el ISBN escaneado
    $book = Book::where('isbn', $request->isbn)->first();

    if ($book) {
        // Si el libro ya existe, actualizar el número de copias sumando la cantidad ingresada
        $book->copies += $validatedData['copies'];
        $book->save();

        \Log::info('Libro existente actualizado con nuevas copias', ['isbn' => $book->isbn, 'new_copies' => $book->copies]);

        return redirect()->route('books.index')->with('success', 'Número de copias actualizado para el libro existente.');
    }

    // Si el libro no existe, crear un nuevo registro
    Book::create($validatedData);

    \Log::info('Nuevo libro guardado en la base de datos', $validatedData);

    // Redirigir con un mensaje de éxito
    return redirect()->route('books.index')->with('success', 'El libro ha sido guardado correctamente.');
}


public function checkISBN($isbn)
{
    $book = Book::where('isbn', $isbn)->first();
    if ($book) {
        return response()->json([
            'exists' => true,
            'copies' => $book->copies,
        ]);
    }
    return response()->json(['exists' => false]);
}



public function manage(Request $request)
{
    // Crear una consulta base para el modelo Book
    $query = Book::query();

    // Aplicar filtros según los parámetros de búsqueda recibidos
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    if ($request->filled('author')) {
        $query->where('author', 'like', '%' . $request->author . '%');
    }

    if ($request->filled('isbn')) {
        $query->where('isbn', 'like', '%' . $request->isbn . '%');
    }

    if ($request->filled('theme')) {
        $query->where('theme', $request->theme);
    }

    // Obtener los resultados de la consulta con paginación
    $books = $query->paginate(10); // Ajusta el número de resultados por página si es necesario

    // Retornar la vista de administración de libros con los resultados filtrados
    return view('books.manage', compact('books'));
}


public function showScan()
{
    return view('books.scan');
}
public function search(Request $request)
{
    // Crear una consulta base para buscar libros en la base de datos
    $query = Book::query();

    // Aplicar filtros según los parámetros de búsqueda
    if ($request->filled('isbn')) {
        $query->where('isbn', 'like', '%' . $request->isbn . '%');
    }

    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    if ($request->filled('author')) {
        $query->where('author', 'like', '%' . $request->author . '%');
    }

    if ($request->filled('theme')) {
        $query->where('theme', $request->theme);
    }

    // Obtener los resultados de la consulta
    $books = $query->get();

    // Retornar una vista con los resultados de la búsqueda
    return view('books.search_results', compact('books'));
}
}