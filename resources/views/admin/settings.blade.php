@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Paramètres') }}
    </h2>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Paramètres de l'application</h3>

            <div class="mb-6">
                <h4 class="font-medium text-gray-700 mb-2">Gestion des données</h4>
                <ul class="list-disc list-inside ml-4 space-y-2">
                    <li>
                        <a href="{{ route('admin.type-cultures') }}" class="text-indigo-600 hover:underline">
                            Gérer les types de cultures
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.type-interventions') }}" class="text-indigo-600 hover:underline">
                            Gérer les types d'interventions
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-6">
                <h4 class="font-medium text-gray-700 mb-2">Gestion des utilisateurs</h4>
                <ul class="list-disc list-inside ml-4 space-y-2">
                    <li>
                        <a href="{{ route('admin.users') }}" class="text-indigo-600 hover:underline">
                            Gérer les utilisateurs
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
