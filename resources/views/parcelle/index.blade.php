@extends('layouts.principal')

@section('title', 'Liste des Parcelles')

@section('content')

<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl text-white font-bold mb-4">Liste des Parcelles</h1>
    <a href="{{ route('parcelle.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
        Ajouter une nouvelle parcelle
    </a>

</div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif
<div class="bg-white p-4 rounded-md shadow-md">
    <table id="parcelleTable" class="w-full text-left">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Superficie</th>
                <th class="border px-4 py-2">Type Culture</th>
                <th class="border px-4 py-2">Date Plantation</th>
                <th class="border px-4 py-2">Statut</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parcelles as $parcelle)
            <tr class="bg-white">
                <td class="border px-4 py-2">{{ $parcelle->nom_parcelle }}</td>
                <td class="border px-4 py-2">{{ $parcelle->superficie }} ha</td>
                <td class="border px-4 py-2">{{ $parcelle->typeCulture->libelle }}</td>
                <td class="border px-4 py-2">{{ $parcelle->date_plantation }}</td>
                <td class="border px-4 py-2">{{ $parcelle->statut }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('parcelle.edit', $parcelle->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Modifier</a>
                    <form action="{{ route('parcelle.destroy', $parcelle->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>

<script>
    $(document).ready( function () {
        $('#parcelleTable').DataTable();
        
    });
</script>
@endsection
