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

            <div class="mb-6 border-t pt-4">
                <h3 class="text-lg font-semibold mb-2">Localisation de la parcelle</h3>
                <p class="text-sm text-gray-600 mb-4">Ces coordonnées serviront à afficher votre parcelle sur la carte.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Latitude</label>
                        <input type="number" name="latitude" step="any" min="-90" max="90" class="w-full border rounded px-4 py-2" placeholder="Ex: 48.856614">
                        <p class="text-xs text-gray-500 mt-1">Entre -90 et 90 degrés</p>
                    </div>

                    <div>
                        <label class="block text-gray-700">Longitude</label>
                        <input type="number" name="longitude" step="any" min="-180" max="180" class="w-full border rounded px-4 py-2" placeholder="Ex: 2.3522219">
                        <p class="text-xs text-gray-500 mt-1">Entre -180 et 180 degrés</p>
                    </div>
                </div>

                <p class="text-sm text-gray-600 mt-2">
                    <a href="https://www.latlong.net/" target="_blank" class="text-blue-500 hover:underline">
                        Trouver les coordonnées sur une carte <i class="bi bi-box-arrow-up-right ml-1"></i>
                    </a>
                </p>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Ajouter</button>
        </form>
    </div>
</div>
@endsection
