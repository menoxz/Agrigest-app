@extends('layouts.principal')

@section('content')

    <h1 class="text-2xl text-white font-bold mb-4">Ajouter un nouvel imprevu</h1>

    <a href="{{ route('imprevu.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
        Retour à la liste
    </a>

    <div class="bg-white p-4 rounded-md shadow-md">
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('imprevu.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full border rounded px-4 py-2" rows="3" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Intervention associée</label>
                <select name="intervention_id" class="w-full border rounded px-4 py-2" required>
                    <option value="">Sélectionner une intervention</option>
                    @foreach ($interventions as $intervention)
                        <option value="{{ $intervention->id }}">
                            {{ $intervention->description }} - {{ $intervention->date_intervention }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Ajouter</button>
        </form>
    </div>

@endsection
