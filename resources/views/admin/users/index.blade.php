<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Gestion des utilisateurs</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-black px-4 py-2 rounded-md hover:bg-indigo-700">
                Ajouter un utilisateur
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:user-search />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
