@extends('layouts.principal')

@section('title', 'Modifier Type Intervention')

@section('content')

<h1 class="text-2xl text-white font-bold mb-4">Modifier Type de Intervention</h1>
<a href="{{ route('type-intervention.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
    Retour à la liste
</a>
<form action="{{ route('type-intervention.update', $typeIntervention->id) }}" method="POST" class="bg-white p-4 rounded-md shadow-md">
    @csrf
    @method('PUT')
    <label class="block mb-2">Nom du Type de Intervention :</label>
    <input type="text" name="libelle" class="w-full border p-2 rounded-md" value="{{ $typeIntervention->libelle }}" required>
    
    <button type="submit" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-md">Mettre à jour</button>
</form>

@endsection
