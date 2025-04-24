@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Modifier un Type d\'Intervention') }}
    </h2>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('admin.type-interventions.update', $typeIntervention) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
                    <input type="text" name="libelle" id="libelle"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('libelle') border-red-500 @enderror"
                        value="{{ old('libelle', $typeIntervention->libelle) }}" required>
                    @error('libelle')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('admin.type-interventions') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Annuler
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
