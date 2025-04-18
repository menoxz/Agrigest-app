@extends('layouts.principal')

@section('title', 'Type Culture')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl text-green-800 font-bold">🌿 Types de culture enregistrés</h1>
    <a href="{{ route('type-culture.create') }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-md shadow">
        ➕ Ajouter un type de culture
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 border border-green-400 px-4 py-3 rounded mb-6 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<!-- Conteneur du tableau -->
<div class="bg-white p-6 rounded-lg shadow-lg">
    <table id="typeCultureTable" class="w-full text-left border border-gray-200 rounded overflow-hidden">
        <thead class="bg-green-100 text-green-900 uppercase text-sm">
            <tr>
                <th class="p-3">Libellé</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @foreach($cultures as $culture)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3 font-medium">{{ $culture->libelle }}</td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('type-culture.edit', $culture->id) }}"
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow"
                       title="Modifier">
                        ✏️
                    </a>

                    <form action="{{ route('type-culture.destroy', $culture->id) }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="flex items-center justify-center text-red-500 p-2 border border-red-500 rounded hover:bg-red-100 transition delete-btn"
                                title="Supprimer">
                            <i class="bi bi-trash"></i>
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
        $('#typeCultureTable').DataTable({
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
            }
        });
    });
</script>

@endsection
