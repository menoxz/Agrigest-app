@extends('layouts.admin')

@section('header', 'Gestion des utilisateurs')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Gestion des utilisateurs</h2>
        <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
            Ajouter un utilisateur
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <livewire:user-search />
        </div>
    </div>
@endsection
