<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>{{ config('app.name', 'Agrigest') }} - @yield('title', 'Accueil')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-green-100 flex">

    <!-- Sidebar -->
    <div class="sidebar fixed top-0 left-0 h-full w-[260px] bg-green-900 text-white p-5">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold">🌿 Agrigest</h1>
            <i class="bi bi-x text-xl cursor-pointer lg:hidden" onclick="openSidebar()"></i>
        </div>

        <div class="mt-6">
            <a href="{{ route('statistiques.globales.detail') }}" class="flex items-center space-x-3 py-3 px-4 rounded-md hover:bg-green-700">
                <i class="bi bi-house-door-fill"></i>
                <span>Statistiques</span>
            </a>
            <a href="{{ route('type-culture.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-md hover:bg-green-700">
                <i class="bi bi-tree"></i>
                <span>Type Culture</span>
            </a>
            <a href="{{ route('type-intervention.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-md hover:bg-green-700">
                <i class="bi bi-gear"></i>
                <span>Type Intervention</span>
            </a>
            <a href="{{ route('parcelle.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-md hover:bg-green-700">
                <i class="bi bi-map"></i>
                <span>Parcelles</span>
            </a>

            <a href="{{ route('intervention.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-md hover:bg-green-700">
                </i> <i class="bi bi-hammer"></i>
                <span>Interventions</span>
            </a>

            <a href="{{ route('imprevu.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-md hover:bg-green-700">
                <i class="bi bi-bug-fill"></i>
                <span>Imprevus</span>
            </a>

        </div>

        <div class="mt-10 border-t border-green-600 pt-5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 py-3 px-4 rounded-md hover:bg-red-700 w-full text-left">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>

    </div>

    <!-- Contenu principal -->
    <div class="flex-1 p-6 lg:ml-[260px]">
        <!-- Barre de navigation -->
        <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-green-900">@yield('title')</h2>
            <button class="lg:hidden text-green-900" onclick="openSidebar()">
                <i class="bi bi-list text-2xl"></i>
            </button>
        </div>

        <!-- Contenu dynamique -->
        <div class="mt-6 bg-white p-6 rounded-lg shadow-md">
            @yield('content')
        </div>
    </div>

    <script>
        function openSidebar() {
            document.querySelector(".sidebar").classList.toggle("hidden");
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Confirmer la suppression ?',
                        text: "Cette action est irréversible.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler',
                        background: '#ffffff',
                        customClass: {
                            popup: 'rounded-lg shadow-lg',
                            title: 'text-lg font-semibold text-gray-800',
                            htmlContainer: 'text-sm text-gray-600',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Afficher un message de succès si présent dans la session
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('success') }}',
                    background: '#ffffff',
                    confirmButtonColor: '#3085d6',
                    customClass: {
                        popup: 'rounded-lg shadow-lg',
                        title: 'text-lg font-semibold text-gray-800',
                        htmlContainer: 'text-sm text-gray-600',
                    }
                });
            @endif
        });
    </script>
</body>
</html>
