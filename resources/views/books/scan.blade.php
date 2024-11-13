@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Escanear ISBN</h1>
            
            <!-- Estilos para el botón de búsqueda -->
            <style>
                #fetch-info-btn {
                    position: relative;
                    z-index: 1000;
                    pointer-events: auto;
                }
                .book-detail {
                    display: flex;
                    align-items: flex-start;
                    gap: 20px;
                    margin-top: 20px;
                }
                .book-detail img {
                    max-width: 150px;
                    border-radius: 5px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .book-info {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                }
                .book-info p {
                    font-size: 1rem;
                    color: #333;
                }
            </style>

            <!-- Contenedor donde se mostrará el video del escaneo -->
            <div id="scanner-container" style="width: 100%; position: relative;">
                <video id="video" width="100%" autoplay></video>
            </div>

            <!-- Muestra el ISBN detectado -->
            <div id="isbn-result" class="mt-4">
                <p>ISBN detectado: <span id="isbn-code"></span></p>
            </div>

            <!-- Formulario para el ISBN -->
            <form id="isbn-form">
                <div class="mb-4">
                    <label for="isbn" class="block text-gray-700 text-sm font-bold mb-2">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Botón para buscar información del libro -->
                <button type="button" id="fetch-info-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Buscar información del libro
                </button>
            </form>

            <!-- Contenedor para mostrar la información del libro obtenida de la API -->
            <div id="book-info" class="book-detail" style="display: none;">
                <!-- Los detalles del libro se mostrarán aquí -->
                <img id="cover-image" src="" alt="Portada del libro">
                <div class="book-info">
                    <p><strong>Título:</strong> <span id="title"></span></p>
                    <p><strong>Autor:</strong> <span id="author"></span></p>
                    <p><strong>Editorial:</strong> <span id="publisher"></span></p>
                    <p><strong>Fecha de Publicación:</strong> <span id="published_at"></span></p>
                    <p><strong>Temática:</strong> <span id="theme"></span></p>
                    <p><strong>Cantidad de Copias:</strong> <span id="copies"></span></p>
                    <p><strong>ISBN:</strong> <span id="isbn-display"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cargar Quagga y Axios -->
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
                readers: ["ean_reader"], // Lee códigos ISBN/EAN-13
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
        });

        // Evento de clic en el botón para buscar información del libro
        document.getElementById('fetch-info-btn').addEventListener('click', function() {
            const isbn = document.getElementById('isbn').value;
            if (!isbn) {
                alert("No hay ningún ISBN escaneado o ingresado.");
                return;
            }

            console.log("Buscando información para ISBN: ", isbn);

            // Llamada AJAX a la API para obtener la información del libro
            axios.get(`/books/fetch-info?isbn=${isbn}`)
                .then(response => {
                    const book = response.data;
                    console.log("Datos del libro recibidos: ", book);

                    // Verificar si hay un error en los datos devueltos
                    if (book.error) {
                        document.getElementById('book-info').innerHTML = `<p>${book.error}</p>`;
                        return;
                    }

                    // Mostrar los detalles del libro
                    document.getElementById('title').textContent = book.title;
                    document.getElementById('author').textContent = book.author;
                    document.getElementById('publisher').textContent = book.publisher;
                    document.getElementById('published_at').textContent = book.published_at;
                    document.getElementById('theme').textContent = book.theme || "No disponible";
                    document.getElementById('copies').textContent = book.copies || "No disponible";
                    document.getElementById('isbn-display').textContent = isbn;

                    // Mostrar la portada si está disponible
                    const coverImage = book.cover || "https://via.placeholder.com/150";
                    document.getElementById('cover-image').src = coverImage;

                    // Mostrar el contenedor de la información del libro
                    document.getElementById('book-info').style.display = 'flex';
                })
                .catch(error => {
                    console.error("Error al obtener la información del libro:", error);
                    document.getElementById('book-info').innerHTML = `<p>Error al obtener la información del libro. Inténtalo de nuevo.</p>`;
                });
        });
    });
</script>
@endsection
<style>
    .drawingBuffer {
        display: none; /* O usa width y height para reducir el tamaño */
    }
</style>