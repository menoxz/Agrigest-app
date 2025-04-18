@extends('layouts.admin')

@section('header', 'Ajouter une parcelle')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Informations de la parcelle</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Remplissez les informations nécessaires pour créer une nouvelle parcelle.
                </p>
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('admin.parcelles.store') }}" method="POST">
                @csrf
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="nom_parcelle" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="nom_parcelle" id="nom_parcelle" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="superficie" class="block text-sm font-medium text-gray-700">Superficie (ha)</label>
                                <input type="number" step="0.01" name="superficie" id="superficie" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="type_culture_id" class="block text-sm font-medium text-gray-700">Type de culture</label>
                                <select name="type_culture_id" id="type_culture_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    @foreach($typeCultures as $typeCulture)
                                        <option value="{{ $typeCulture->id }}">{{ $typeCulture->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="date_plantation" class="block text-sm font-medium text-gray-700">Date de plantation</label>
                                <input type="date" name="date_plantation" id="date_plantation" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('admin.parcelles') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Annuler
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Créer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
