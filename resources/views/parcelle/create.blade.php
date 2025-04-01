@extends('layouts.principal')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Ajouter une nouvelle parcelle</h1>

    <a href="{{ route('parcelle.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
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

        <form action="{{ route('parcelle.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Nom de la parcelle</label>
                <input type="text" name="nom_parcelle" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Superficie (ha)</label>
                <input type="number" name="superficie" step="0.01" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Type de culture</label>
                <select name="type_culture_id" class="w-full border rounded px-4 py-2" required>
                    <option value="">Sélectionner un type</option>
                    @foreach ($typeCulture as $type)
                        <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Date de plantation</label>
                <input type="date" name="date_plantation" class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Statut</label>
                <select name="statut" class="w-full border rounded px-4 py-2" required>
                    <option value="En culture">En culture</option>
                    <option value="Récoltée">Récoltée</option>
                    <option value="En jachère">En jachère</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Ajouter</button>
        </form>
    </div>
</div>
@endsection
