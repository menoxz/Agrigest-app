@extends('layouts.principal')

@section('title', 'Liste des Parcelles')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl text-green-800 font-bold">🌾 Mes parcelles</h1>
    <a href="{{ route('parcelle.create') }}"
       class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-md shadow">
        ➕ Ajouter une parcelle
    </a>
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

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('parcelle.edit', $parcelle->id) }}"
                   class="text-yellow-600 hover:text-yellow-800 px-3 py-1 border border-yellow-400 rounded text-sm flex items-center gap-1">
                    ✏️ Modifier
                </a>

                <form action="{{ route('parcelle.destroy', $parcelle->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-red-600 hover:text-red-800 px-3 py-1 border border-red-400 rounded text-sm flex items-center gap-1">
                        🗑️ Supprimer
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-500 col-span-3 text-center">Aucune parcelle enregistrée.</p>
    @endforelse
</div>

@endsection
