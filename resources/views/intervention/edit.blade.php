@extends('layouts.principal')

@section('title', 'Modifier Intervention')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Modifier l'intervention</h1>

    <a href="{{ route('intervention.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
        Retour à la liste
    </a>

    <div class="bg-white p-6 rounded-lg shadow-md">
        @if ($errors->any())
            <div class="bg-red-200 p-4 rounded-md mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('intervention.update', $intervention->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Date d'intervention</label>
                <input type="date" name="date_intervention" value="{{ $intervention->date_intervention }}" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full border rounded px-4 py-2" rows="3" required>{{ $intervention->description }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Quantité Produit</label>
                <input type="number" step="0.01" name="qte_produit" value="{{ $intervention->qte_produit }}" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Date de fin</label>
                <input type="date" name="date_fin" value="{{ $intervention->date_fin }}" class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Statut</label>
                <select name="statut_intervention" class="w-full border rounded px-4 py-2" required>
                    <option value="En cours" {{ $intervention->statut_intervention == 'En cours' ? 'selected' : '' }}>En cours</option>
                    <option value="Terminée" {{ $intervention->statut_intervention == 'Terminée' ? 'selected' : '' }}>Terminée</option>
                    <option value="En attente" {{ $intervention->statut_intervention == 'En attente' ? 'selected' : '' }}>En attente</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Parcelle</label>
                <select name="parcelle_id" class="w-full border rounded px-4 py-2" required>
                    @foreach ($parcelles as $parcelle)
                        <option value="{{ $parcelle->id }}" {{ $intervention->parcelle_id == $parcelle->id ? 'selected' : '' }}>
                            {{ $parcelle->nom_parcelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Type d'intervention</label>
                <select name="type_intervention_id" class="w-full border rounded px-4 py-2" required>
                    @foreach ($typeInterventions as $type)
                        <option value="{{ $type->id }}" {{ $intervention->type_intervention_id == $type->id ? 'selected' : '' }}>
                            {{ $type->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-md">Modifier</button>
        </form>
    </div>
</div>
@endsection
