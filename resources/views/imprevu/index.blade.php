@extends('layouts.principal')

@section('title', 'Liste des Imprevus')

@section('content')

<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl text-white font-bold">Liste des Imprevus</h1>
    <a href="{{ route('imprevu.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Ajouter un nouvel imprevu</a>
</div>

@if(session('success'))
    <div class="bg-green-500 text-white p-3 rounded-md mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-4 rounded-md shadow-md">
    <table id="imprevuTable" class="full text-left">
        <thead>
            <tr>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Intervention associee</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($imprevus as $imprevu)
                <tr>
                    <td class="border px-4 py-2">{{ $imprevu->description }}</td>
                    <td class="border px-4 py-2">{{ $imprevu->intervention->typeIntervention->libelle }}</td>
                    <td class="border px-4 py-2 flex gap-2">
                        <a href="{{ route('imprevu.edit', $imprevu->id) }}"
                           class="flex items-center justify-center bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600 transition"
                           title="Modifier">
                            <i class="bi bi-pencil-square"></i>
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

    <!-- Ajout de jQuery et DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

    <script>
        $(document).ready(function() {
            $('#imprevuTable').DataTable();
        });
    </script>

@endsection