<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <title>@yield('title', 'Dashboard')</title>
</head>
<body class="bg-blue-600">

    <!-- Sidebar -->
    <span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="openSidebar()">
        <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
    </span>

    <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-900">
        <div class="text-gray-100 text-xl">
            <div class="p-2.5 mt-1 flex items-center">
                <i class="bi bi-app-indicator px-2 py-1 rounded-md bg-blue-600"></i>
                <h1 class="font-bold text-gray-200 text-[15px] ml-3">Agrigest App</h1>
                <i class="bi bi-x cursor-pointer ml-28 lg:hidden" onclick="openSidebar()"></i>
            </div>
            <div class="my-2 bg-gray-600 h-[1px]"></div>
        </div> 

        <!-- Menu -->
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
             onclick="changeMessage('Dashboard')">
            <i class="bi bi-house-door-fill"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Dashboard</span>
        </div>

        <!-- Lien dynamique vers la page Type Culture -->
        <a href="{{ route('type-culture.index') }}" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="bi bi-node-plus"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">TYPE CULTURE</span>
        </a>
        <!-- Lien dynamique vers la page Type Intervention -->
        <a href="{{ route('type-intervention.index') }}" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="bi bi-x-diamond-fill"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">TYPE INTERVENTION</span>
        </a>
        
        <a href="{{ route('imprevus.index') }}" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="bi bi-app-indicator"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">IMPRÉVUS</span>
        </a>

        <div class="my-4 bg-gray-600 h-[1px]"></div>

        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="bi bi-box-arrow-in-right"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Déconnexion</span>
        </div>
    </div>

    <!-- Contenu de la page -->
    <div class="ml-[320px] p-5">
        <!-- Message dynamique -->
        <div id="messageBox" class="hidden bg-gray-800 text-white p-3 rounded-md mb-4"></div>

        @yield('content')
    </div>

    <script>
        function openSidebar() {
            document.querySelector(".sidebar").classList.toggle("hidden");
        }

        function changeMessage(message) {
            let messageBox = document.getElementById("messageBox");
            messageBox.innerText = "Vous avez sélectionné : " + message;
            messageBox.classList.remove("hidden");
        }
    </script>
</body>
</html>
