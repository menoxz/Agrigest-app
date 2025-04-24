@extends('layouts.principal')

@section('title', 'Liste des Parcelles')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl text-green-800 font-bold">🌾 Mes parcelles</h1>
    <div class="flex space-x-2">
        <a href="{{ route('parcelle.map.all') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow flex items-center">
            <i class="bi bi-map-fill mr-2"></i> Voir sur la carte
        </a>
        <a href="{{ route('parcelle.create') }}"
           class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-md shadow">
            <i class="bi bi-plus-circle mr-1"></i> Ajouter une parcelle
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 border border-green-400 px-4 py-3 rounded mb-6 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<!-- Grille responsive -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse($parcelles as $parcelle)
        <div class="bg-white rounded-lg shadow-md p-5 border-l-4 border-green-500 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-3">
                <h2 class="text-xl font-bold text-green-800">{{ $parcelle->nom_parcelle }}</h2>
                <span class="text-sm px-2 py-1 rounded-full
                    @if($parcelle->statut === 'En culture') bg-green-100 text-green-800
                    @elseif($parcelle->statut === 'Récoltée') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $parcelle->statut }}
                </span>
            </div>

            <p><span class="font-semibold">🌱 Type :</span> {{ $parcelle->typeCulture->libelle }}</p>
            <p><span class="font-semibold">📐 Superficie :</span> {{ $parcelle->superficie }} ha</p>
            <p><span class="font-semibold">📅 Plantation :</span> {{ \Carbon\Carbon::parse($parcelle->date_plantation)->format('d/m/Y') }}</p>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('parcelle.map', $parcelle->id) }}"
                   class="text-blue-600 hover:text-blue-800 px-3 py-1 border border-blue-400 rounded text-sm flex items-center gap-1">
                    <i class="bi bi-map"></i> Voir sur la carte
                </a>

                <div class="flex gap-2">
                    <a href="{{ route('parcelle.edit', $parcelle->id) }}"
                       class="text-yellow-600 hover:text-yellow-800 px-3 py-1 border border-yellow-400 rounded text-sm flex items-center gap-1">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>

                    <form action="{{ route('parcelle.destroy', $parcelle->id) }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="flex items-center justify-center text-red-500 p-2 border border-red-500 rounded hover:bg-red-100 transition delete-btn"
                                 title="Supprimer">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500 col-span-3 text-center">Aucune parcelle enregistrée.</p>
    @endforelse
</div>

@endsection
