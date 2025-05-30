@extends('layouts.principal')
@section('title', 'Modifier Parcelle')
@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Modifier la parcelle</h1>

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

        <form action="{{ route('parcelle.update', $parcelle->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Nom de la parcelle</label>
                <input type="text" name="nom_parcelle" value="{{ $parcelle->nom_parcelle }}" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Superficie (ha)</label>
                <input type="number" name="superficie" step="0.01" value="{{ $parcelle->superficie }}" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Type de culture</label>
                <select name="type_culture_id" class="w-full border rounded px-4 py-2" required>
                    @foreach ($typeCulture as $type)
                        <option value="{{ $type->id }}" {{ $parcelle->type_culture_id == $type->id ? 'selected' : '' }}>
                            {{ $type->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Date de plantation</label>
                <input type="date" name="date_plantation" value="{{ $parcelle->date_plantation }}" class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Statut</label>
                <select name="statut" class="w-full border rounded px-4 py-2" required>
                    <option value="En culture" {{ $parcelle->statut == 'En culture' ? 'selected' : '' }}>En culture</option>
                    <option value="Récoltée" {{ $parcelle->statut == 'Récoltée' ? 'selected' : '' }}>Récoltée</option>
                    <option value="En jachère" {{ $parcelle->statut == 'En jachère' ? 'selected' : '' }}>En jachère</option>
                </select>
            </div>

            <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-md">Modifier</button>
        </form>
    </div>
</div>
@endsection
