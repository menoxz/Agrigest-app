@extends('layouts.principal')

@section('title', 'Type Intervention')

@section('content')

<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl text-white font-bold">Liste des Types de Intervention</h1>
    <a href="{{ route('type-intervention.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Ajouter une nouvelle type d'intervention</a>
</div>

@if(session('success'))
    <div class="bg-green-500 text-white p-3 rounded-md mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-4 rounded-md shadow-md">
    <table id="typeInterventionTable" class="w-full text-left">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">ID</th>
                <th class="p-2">libelle</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($interventions as $intervention)
            <tr class="border-t">
                <td class="p-2">{{ $intervention->id }}</td>
                <td class="p-2">{{ $intervention->libelle }}</td>
                <td class="p-2">
                    <a href="{{ route('type-intervention.edit', $intervention->id) }}" class="text-blue-500">Modifier</a>
                    <form action="{{ route('type-intervention.destroy', $intervention->id) }}" method="POST" class="inline-block">
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
        $('#typeInterventionTable').DataTable();
    });
</script>

@endsection
