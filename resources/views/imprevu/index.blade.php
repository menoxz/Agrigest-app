@extends('layouts.principal')

@section('title', 'Imprévus')

@section('content')

<!-- Titre et bouton d'ajout -->
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-red-800">⚠️ Liste des Imprévus</h1>
    <a href="{{ route('imprevu.create') }}"
       class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow">
        ➕ Ajouter un imprévu
    </a>
</div>

<!-- Message de succès -->
@if(session('success'))
    <div class="bg-green-100 text-green-800 border border-green-400 px-4 py-3 rounded mb-6 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<!-- Tableau des imprévus -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <table id="imprevuTable" class="w-full text-left border border-gray-200 rounded overflow-hidden">
        <thead class="bg-red-100 text-red-800 uppercase text-sm">
            <tr>
                <th class="p-3">Description</th>
                <th class="p-3">Type d'intervention liée</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach ($imprevus as $imprevu)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $imprevu->description }}</td>
                    <td class="p-3">
                        <span class="inline-block bg-orange-100 text-orange-800 text-sm font-semibold px-3 py-1 rounded-full">
                            {{ $imprevu->intervention->typeIntervention->libelle }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('imprevu.edit', $imprevu->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow text-sm"
                           title="Modifier">
                            ✏️ Modifier
                        </a>
                        <form action="{{ route('imprevu.destroy', $imprevu->id) }}" method="POST" class="inline delete-form">
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

<script>
    $(document).ready(function() {
        $('#imprevuTable').DataTable({
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
                    sortAscending:  ": activer pour trier par ordre croissant",
                    sortDescending: ": activer pour trier par ordre décroissant"
                }
            },
                });
    });
</script>

@endsection
