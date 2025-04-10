@extends('layouts.principal')

@section('title', 'liste des interventions')

@section('content')

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl text-white font-bold mb-4">Liste des Interventions</h1>
        <a href="{{ route('intervention.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
            Ajouter une nouvelle intervention
        </a>

    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-md shadow-md overflow-x-auto">
        <table id="interventionTable" class="min-w-full text-left">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Utilisateur</th>
                    <th class="border px-4 py-2">Parcelle</th>
                    <th class="border px-4 py-2">Date d'intervention</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Date de fin</th>
                    <th class="border px-4 py-2">Type d'intervention</th>
                    <th class="border px-4 py-2">Quantité Produit</th>
                    <th class="border px-4 py-2">Statut</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($interventions as $intervention)
                    <tr class="bg-white">
                        <td class="border px-4 py-2">{{ $intervention->user->name }}</td>
                        <td class="border px-4 py-2">{{ $intervention->parcelle->nom_parcelle }}</td>
                        <td class="border px-4 py-2">{{ $intervention->date_intervention }}</td>
                        <td class="border px-4 py-2">{{ $intervention->description }}</td>
                        <td class="border px-4 py-2">{{ $intervention->date_fin }}</td>
                        <td class="border px-4 py-2">{{ $intervention->typeIntervention->libelle }}</td>
                        <td class="border px-4 py-2">{{ $intervention->qte_produit }}</td>
                        <td class="border px-4 py-2">{{ $intervention->statut_intervention }}</td>
                        <td class="border px-4 py-2 flex gap-2">
                            <a href="{{ route('intervention.edit', $intervention->id) }}"
                               class="flex items-center justify-center bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600 transition"
                               title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        
                            <form action="{{ route('intervention.destroy', $intervention->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="flex items-center justify-center text-red-500 p-2 border border-red-500 rounded hover:bg-red-100 transition"
                                        onclick="return confirm('Confirmer la suppression ?')" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Ajout de jQuery et DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

    <script>
        $(document).ready(function() {
            $('#interventionTable').DataTable();
        });
    </script>

@endsection
