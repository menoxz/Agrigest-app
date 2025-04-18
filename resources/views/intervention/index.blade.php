@extends('layouts.principal')

@section('title', 'Liste des interventions')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-blue-800">🛠️ Interventions enregistrées</h1>
    <a href="{{ route('intervention.create') }}"
       class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md shadow">
        ➕ Ajouter une intervention
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 border border-green-400 px-4 py-3 rounded mb-6 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<!-- Grille responsive -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($interventions as $intervention)
        <div class="bg-white shadow-md rounded-lg p-5 border-l-4 border-blue-500 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-2">
                <h2 class="text-xl font-bold text-blue-800">{{ $intervention->typeIntervention->libelle }}</h2>
                <span class="text-xs px-2 py-1 rounded-full 
                    @if($intervention->statut_intervention === 'terminée') bg-green-100 text-green-800 
                    @elseif($intervention->statut_intervention === 'annulée') bg-red-100 text-red-800 
                    @else bg-yellow-100 text-yellow-800 
                    @endif">
                    {{ ucfirst($intervention->statut_intervention) }}
                </span>
            </div>

            <div class="text-sm text-gray-600 mb-2">
                <p><span class="font-semibold">👤 Utilisateur :</span> {{ $intervention->user->name }}</p> </br>
                <p><span class="font-semibold">🌱 Parcelle :</span> {{ $intervention->parcelle->nom_parcelle }}</p> </br>
                <p><span class="font-semibold">📅 Date début :</span> {{ \Carbon\Carbon::parse($intervention->date_intervention)->format('d/m/Y') }}</p> </br>
                <p><span class="font-semibold">📆 Fin :</span> {{ $intervention->date_fin ? \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') : 'N/A' }}</p> </br>
                <p><span class="font-semibold">📦 Produit :</span> {{ $intervention->qte_produit }}</p> </br>
                <p class="mt-2 text-gray-800"><span class="font-semibold">📝 Description :</span> {{ $intervention->description }}</p>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('intervention.edit', $intervention->id) }}"
                   class="text-yellow-600 hover:text-yellow-800 px-3 py-1 border border-yellow-400 rounded text-sm flex items-center gap-1">
                    ✏️ Modifier
                </a>

                <form action="{{ route('intervention.destroy', $intervention->id) }}" method="POST" class="inline delete-form">
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
    @empty
        <p class="text-gray-500 col-span-3 text-center">Aucune intervention enregistrée.</p>
    @endforelse
</div>

@endsection
