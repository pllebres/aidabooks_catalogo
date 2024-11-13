@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Escanear y Guardar ISBN</h1>
            <p class="mb-4">Escanea el ISBN de un libro para obtener y guardar la información en la base de datos.</p>

            <!-- Mostrar mensaje de éxito -->
            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Contenedor del escáner de ISBN -->
            <div id="scanner-container" style="width: 100%; position: relative;">
                <video id="video" width="100%" autoplay></video>
            </div>

            <!-- Mostrar el ISBN detectado -->
            <div id="isbn-result" class="mt-4">
                <p>ISBN detectado: <span id="isbn-code"></span></p>
            </div>

            <!-- Mostrar errores de validación -->
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario para guardar el libro escaneado -->
            <form action="{{ route('books.scan-store.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block font-semibold">Título:</label>
                    <input type="text" name="title" id="title" required class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label for="author" class="block font-semibold">Autor:</label>
                    <input type="text" name="author" id="author" required class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label for="isbn" class="block font-semibold">ISBN:</label>
                    <input type="text" name="isbn" id="isbn" required class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label for="publisher" class="block font-semibold">Editorial:</label>
                    <input type="text" name="publisher" id="publisher" required class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label for="published_at" class="block font-semibold">Fecha de publicación:</label>
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
                    <input type="number" name="copies" id="copies" min="1" value="1" class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label for="cover" class="block font-semibold">URL de la Portada:</label>
                    <input type="text" name="cover" id="cover" value="{{ old('cover') }}" class="w-full border border-gray-300 rounded p-2">
                </div>

                <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded">Guardar Libro</button>
            </form>
        </div>
    </div>
</div>

<!-- Scripts para el escaneo y obtención de datos -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("Inicializando Quagga...");

        // Inicializar Quagga para escanear el código de barras
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner-container'),
                constraints: {
                    width: 1280,
                    height: 720,
                    facingMode: "environment" // Usa la cámara trasera
                }
            },
            decoder: {
                readers: ["ean_reader"] // Lee códigos ISBN/EAN-13
            },
            locate: true // Habilitar localización del código de barras
        }, function (err) {
            if (err) {
                console.error("Error al iniciar Quagga:", err);
                return;
            }
            console.log("Quagga iniciado correctamente.");
            Quagga.start();
        });

        // Cuando Quagga detecta un código, muestra el ISBN en el campo del formulario
        Quagga.onDetected(function (data) {
            const isbn = data.codeResult.code;
            console.log("Código detectado: ", isbn);

            // Mostrar el código en pantalla y en el campo del formulario
            document.getElementById('isbn-code').textContent = isbn;
            document.getElementById('isbn').value = isbn;

            // Detener Quagga después de detectar el ISBN
            Quagga.stop();

            // Llamada a la API de Open Library para obtener la información del libro
            fetchBookInfo(isbn);
        });

        // Función para obtener los datos del libro desde la API de Open Library
        function fetchBookInfo(isbn) {
            axios.get(`https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&format=json&jscmd=data`)
                .then(response => {
                    const bookData = response.data[`ISBN:${isbn}`];
                    if (bookData) {
                        console.log("Datos del libro obtenidos:", bookData);
                        // Llenar el formulario con los datos obtenidos de la API
                        document.getElementById('title').value = bookData.title || '';
                        document.getElementById('author').value = (bookData.authors && bookData.authors[0].name) || '';
                        document.getElementById('publisher').value = (bookData.publishers && bookData.publishers[0].name) || '';
                        document.getElementById('published_at').value = bookData.publish_date || '';
                        document.getElementById('cover').value = (bookData.cover && bookData.cover.large) || '';
                    } else {
                        console.log("No se encontraron datos para el ISBN proporcionado.");
                    }
                })
                .catch(error => {
                    console.error("Error al obtener la información del libro:", error);
                });
        }
    });
</script>
@endsection
<style>
    .drawingBuffer {
        display: none; /* O usa width y height para reducir el tamaño */
    }
</style>