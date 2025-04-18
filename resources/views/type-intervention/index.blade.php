@extends('layouts.principal')

@section('title', 'Types d’intervention')

@section('content')

<!-- Titre + bouton -->
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl text-green-800 font-bold">🚜 Liste des types d'intervention</h1>
    <a href="{{ route('type-intervention.create') }}"
       class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-md shadow">
        ➕ Ajouter un type d'intervention
    </a>
</div>

<!-- Message de succès -->
@if(session('success'))
    <div class="bg-green-100 text-green-800 border border-green-400 px-4 py-3 rounded mb-6 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<!-- Conteneur du tableau -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <table id="typeInterventionTable" class="w-full text-left border border-gray-200 rounded overflow-hidden">
        <thead class="bg-green-100 text-green-800 uppercase text-sm">
            <tr>
                <th class="p-3">Libellé</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @foreach($interventions as $intervention)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">
                        @php
                            $badges = ['blue', 'green', 'indigo', 'teal', 'orange', 'lime'];
                            $couleur = $badges[$loop->index % count($badges)];
                        @endphp
                        <span class="inline-block bg-{{ $couleur }}-100 text-{{ $couleur }}-800 text-sm font-semibold px-3 py-1 rounded-full">
                            {{ $intervention->libelle }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('type-intervention.edit', $intervention->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow text-sm"
                           title="Modifier">
                            ✏️ Modifier
                        </a>

                        <form action="{{ route('type-intervention.destroy', $intervention->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Confirmer la suppression ?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-sm"
                                    title="Supprimer">
                                🗑️ Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Scripts DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>

<script>
    $(document).ready(function () {
        $('#typeInterventionTable').DataTable({
            language: {
                processing:     "Traitement en cours...",
                search:         "🔍 Rechercher :",
                lengthMenu:     "Afficher _MENU_ éléments",
                info:           "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
                infoEmpty:      "Aucun élément à afficher",
                infoFiltered:   "(filtré de _MAX_ éléments au total)",
                loadingRecords: "Chargement...",
                zeroRecords:    "Aucun résultat trouvé",
                emptyTable:     "Aucune donnée disponible dans ce tableau",
                paginate: {
                    first:      "Premier",
                    previous:   "Précédent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
                aria: {
                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },
        });
    });
</script>

@endsection
