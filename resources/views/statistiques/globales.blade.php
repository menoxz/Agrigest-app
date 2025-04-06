@extends('layouts.principal')

@section('title', 'Statistiques Globales')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-green-800">📊 Statistiques globales</h1>
        <p class="text-sm text-gray-600 mt-1">{{ $periode }}</p>
    </div>

    <!-- Cartes de statistiques principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total parcelles -->
        <div class="bg-white shadow-md rounded-lg p-5 border-l-4 border-green-600">
            <div class="flex items-center space-x-4">
                <i class="bi bi-map text-3xl text-green-700"></i>
                <div>
                    <h2 class="text-gray-700 font-semibold">Parcelles</h2>
                    <p class="text-2xl font-bold">{{ $statistiques['total_parcelles'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total interventions -->
        <div class="bg-white shadow-md rounded-lg p-5 border-l-4 border-blue-600">
            <div class="flex items-center space-x-4">
                <i class="bi bi-gear-fill text-3xl text-blue-700"></i>
                <div>
                    <h2 class="text-gray-700 font-semibold">Interventions</h2>
                    <p class="text-2xl font-bold">{{ $statistiques['total_interventions'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total imprévus -->
        <div class="bg-white shadow-md rounded-lg p-5 border-l-4 border-red-600">
            <div class="flex items-center space-x-4">
                <i class="bi bi-exclamation-circle-fill text-3xl text-red-700"></i>
                <div>
                    <h2 class="text-gray-700 font-semibold">Imprévus</h2>
                    <p class="text-2xl font-bold">{{ $statistiques['total_imprevus'] }}</p>
                </div>
            </div>
        </div>

        <!-- Durée totale -->
        <div class="bg-white shadow-md rounded-lg p-5 border-l-4 border-yellow-600">
            <div class="flex items-center space-x-4">
                <i class="bi bi-clock-fill text-3xl text-yellow-700"></i>
                <div>
                    <h2 class="text-gray-700 font-semibold">Durée totale</h2>
                    <p class="text-2xl font-bold">{{ $statistiques['duree_totale'] ?? 0 }} h</p>
                </div>
            </div>
        </div>

        <!-- Coût total -->
        <div class="bg-white shadow-md rounded-lg p-5 border-l-4 border-purple-600">
            <div class="flex items-center space-x-4">
                <i class="bi bi-cash-coin text-3xl text-purple-700"></i>
                <div>
                    <h2 class="text-gray-700 font-semibold">Coût total</h2>
                    <p class="text-2xl font-bold">{{ number_format($statistiques['cout_total'] ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <!-- Moyenne interventions -->
        <div class="bg-white shadow-md rounded-lg p-5 border-l-4 border-indigo-600">
            <div class="flex items-center space-x-4">
                <i class="bi bi-bar-chart-line-fill text-3xl text-indigo-700"></i>
                <div>
                    <h2 class="text-gray-700 font-semibold">Interventions / Parcelle</h2>
                    <p class="text-2xl font-bold">{{ $statistiques['moyenne_interventions_par_parcelle'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Répartition par statut -->
    <div class="mt-10">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">📋 Répartition des interventions par statut</h3>
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($statistiques['interventions_par_statut'] as $statut => $count)
                <li class="bg-white p-4 rounded shadow border-l-4 border-green-400">
                    <h4 class="text-md font-medium text-gray-700">{{ ucfirst($statut) }}</h4>
                    <p class="text-xl font-bold text-green-800">{{ $count }}</p>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Top 3 types de culture -->
    <div class="mt-10">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">🏆 Top 3 des types de culture</h3>
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($statistiques['top_types_culture'] as $type)
                <li class="bg-white p-4 rounded shadow border-l-4 border-teal-500">
                    <h4 class="text-md font-medium text-gray-700">{{ $type['libelle'] }}</h4>
                    <p class="text-xl font-bold text-teal-800">{{ $type['nombre_parcelles'] }} parcelle(s)</p>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
