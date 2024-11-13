{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <!-- Link a ver todos los libros, accesible sin autenticación -->
                    <a href="{{ route('books.index') }}" class="text-gray-700 hover:text-gray-900">Catálogo de Libros</a>

                    <!-- Link para escanear ISBN sin guardar, accesible sin autenticación -->
                    <a href="{{ route('books.scan') }}" class="text-gray-700 hover:text-gray-900">Escaneo de ISBN</a>

                    @auth
                        <!-- Link para escanear y guardar ISBN, solo para usuarios autenticados -->
                        <a href="{{ route('books.scan-store') }}" class="text-gray-700 hover:text-gray-900">Escaneo ISBN y almacenamiento</a>

                        <!-- Link para crear libro, solo para usuarios autenticados -->
                        <a href="{{ route('books.create') }}" class="text-gray-700 hover:text-gray-900">Añade un libro</a>

                      <a href="{{ route('books.manage') }}" class="text-sm text-gray-700 dark:text-gray-500">Gestión de libros</a>
    
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.edit') }}">
                                {{ __('Perfil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Opciones para usuarios no autenticados -->
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-gray-900">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
