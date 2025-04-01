@extends('layouts.principal')

@section('title', 'Ajouter Type Culture')

@section('content')

<h1 class="text-2xl text-white font-bold mb-4">Ajouter un Type de Culture</h1>
<a href="{{ route('type-culture.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
    Retour à la liste
</a>
<form action="{{ route('type-culture.store') }}" method="POST" class="bg-white p-4 rounded-md shadow-md">
    @csrf
    <label class="block mb-2">libelle du Type de Culture :</label>
    <input type="text" name="libelle" class="w-1/2  border p-2 rounded-md" required>
</br>
    <button type="submit" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-md">Ajouter</button>
</form>

@endsection
