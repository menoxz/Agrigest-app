@extends('layouts.principal')

@section('title', 'Modifier Imprévu')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Modifier l'imprévu</h1>

    <a href="{{ route('imprevu.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
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

        <form action="{{ route('imprevu.update', $imprevu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full border rounded px-4 py-2" rows="3" required>{{ old('description', $imprevu->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Intervention associée</label>
                <select name="intervention_id" class="w-full border rounded px-4 py-2" required>
                    <option value="">Sélectionner une intervention</option>
                    @foreach ($interventions as $intervention)
                        <option value="{{ $intervention->id }}"
                            {{ $imprevu->intervention_id == $intervention->id ? 'selected' : '' }}>
                            {{ $intervention->description }} - {{ $intervention->date_intervention }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-md">Modifier</button>
        </form>
    </div>
</div>
@endsection
