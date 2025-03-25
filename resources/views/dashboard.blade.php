<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-white">

<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-white dark:bg-gray-800 shadow-md flex flex-col justify-between">
        <div>
            <div class="p-4 text-xl font-bold text-gray-800 dark:text-white">
                Mon Dashboard
            </div>
            <ul>
                <li class="px-6 py-3 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <a href="#" class="flex items-center space-x-2 text-gray-700 dark:text-white">
                        <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m8 0h4m-4 4h4m-4 4h4"></path>
                        </svg>
                        <span>Accueil</span>
                    </a>
                </li>
                <li class="px-6 py-3 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <a href="#" class="flex items-center space-x-2 text-gray-700 dark:text-white">
                        <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Statistiques</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Bouton de déconnexion en bas -->
        <div class="px-6 py-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-2 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"></path>
                    </svg>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <div class="bg-white dark:bg-gray-800 shadow p-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Dashboard</h2>
            <div class="flex items-center space-x-4">
                

                <!-- Nom de l'utilisateur connecté -->
                <span class="text-gray-700 dark:text-white font-semibold">
                    {{ Auth::user()->name }} est connecté
                </span>
            </div>
        </div>

        <!-- Section principale -->
        <div class="p-6 bg-cover bg-center min-h-screen" style="background: url('/image/terrain-agricole.jpg');">
            <div class="grid grid-cols-3 gap-6">
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded">
                    <h3 class="text-lg font-semibold">Statistique 1</h3>
                    <p class="text-gray-600 dark:text-gray-300">Données importantes ici.</p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded">
                    <h3 class="text-lg font-semibold">Statistique 2</h3>
                    <p class="text-gray-600 dark:text-gray-300">Autre donnée ici.</p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded">
                    <h3 class="text-lg font-semibold">Statistique 3</h3>
                    <p class="text-gray-600 dark:text-gray-300">Encore une autre info.</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
