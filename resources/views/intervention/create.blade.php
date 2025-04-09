@extends('layouts.principal')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Ajouter une nouvelle intervention</h1>

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

        <form action="{{ route('intervention.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Date d'intervention</label>
                <input type="date" name="date_intervention" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full border rounded px-4 py-2" rows="3" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Quantité Produit</label>
                <input type="number" step="0.01" name="qte_produit" class="w-full border rounded px-4 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Statut</label>
                <select name="statut_intervention" class="w-full border rounded px-4 py-2" required>
                    <option value="En cours">En cours</option>
                    <option value="Terminée">Terminée</option>
                    <option value="En attente">En attente</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Parcelle</label>
                <select name="parcelle_id" class="w-full border rounded px-4 py-2" required>
                    <option value="">Sélectionner une parcelle</option>
                    @foreach ($parcelles as $parcelle)
                        <option value="{{ $parcelle->id }}">{{ $parcelle->nom_parcelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Type d'intervention</label>
                <select name="type_intervention_id" class="w-full border rounded px-4 py-2" required>
                    <option value="">Sélectionner un type</option>
                    @foreach ($typeInterventions as $typeIntervention)
                        <option value="{{ $typeIntervention->id }}">{{ $typeIntervention->libelle }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="mb-4">
                <label class="block text-gray-700">Imprévu associé</label>
                <select name="imprevu_id" class="w-full border rounded px-4 py-2" required>
                    <option value="">Sélectionner un imprévu</option>
                    @foreach ($imprevus as $imprevu)
                        <option value="{{ $imprevu->id }}">{{ $imprevu->description }}</option>
                    @endforeach
                </select>
            </div> --}}

            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Ajouter</button>
        </form>
    </div>
</div>
@endsection
