@extends('layouts.principal')

@section('title', 'Modifier Type Culture')

@section('content')

<h1 class="text-2xl text-white font-bold mb-4">Modifier Type de Culture</h1>

<form action="{{ route('type-culture.update', $typeCulture->id) }}" method="POST" class="bg-white p-4 rounded-md shadow-md">
    @csrf
    @method('PUT')
    <label class="block mb-2">Nom du Type de Culture :</label>
    <input type="text" name="libelle" class="w-full border p-2 rounded-md" value="{{ $typeCulture->libelle }}" required>
    
    <button type="submit" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-md">Mettre à jour</button>
</form>

@endsection
