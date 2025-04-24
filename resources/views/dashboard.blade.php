@extends('layouts.principal')

@section('title', 'Dashboard')

@section('content')
<div class="mt-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-green-800 mb-4">Bienvenue, {{ Auth::user()->name }} ! 👋</h2>
        <p class="text-gray-600">Gérez efficacement vos parcelles et vos interventions agricoles.</p>
    </div>
</div>


@endsection
