<div class="flex flex-col min-h-screen">
    <header>
        <nav class="bg-gray-800 p-4">
            <div class="container mx-auto">
                <a href="/" class="text-white">Inicio</a>
                <!-- Agrega aquí más enlaces según sea necesario -->
            </div>
        </nav>
    </header>

    <main class="flex-grow">
        {{ $slot }} <!-- Aquí se inyectará el contenido de las vistas que usan este layout -->
    </main>

    <footer class="bg-gray-800 text-white text-center p-4">
        &copy; {{ date('Y') }} Tu Aplicación
    </footer>
</div>
