<!-- resources/views/partials/header.blade.php -->
<header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center p-4">

    <a href="/" class="flex items-center space-x-2">
            <img src="{{ asset('/public/images/AIDA-ONG-logo-150x129.png') }}" alt="Logo" class="h-8 w-8">
        
        </a>

        <!-- Aquí puedes incluir el dropdown menu -->
        @include('partials.dropdown-menu')
    </div>
</header>
