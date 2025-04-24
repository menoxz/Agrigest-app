@extends('layouts.principal')

@section('title', 'Carte des Parcelles')

@section('content')
<div class="mb-6">
    <a href="{{ route('parcelle.index') }}" class="inline-flex items-center text-green-700 hover:text-green-900">
        <i class="bi bi-arrow-left mr-2"></i> Retour à la liste des parcelles
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-green-800 mb-4">
        @if(isset($parcelle))
            Localisation de la parcelle : {{ $parcelle->nom_parcelle }}
        @else
            Carte de toutes mes parcelles
        @endif
    </h1>

    @if(isset($parcelle) && !$parcelle->hasLocation())
        <div class="bg-yellow-100 text-yellow-800 p-4 mb-4 rounded-md">
            Cette parcelle n'a pas de coordonnées géographiques définies.
            <a href="{{ route('parcelle.edit', $parcelle->id) }}" class="underline">Modifier la parcelle</a> pour ajouter sa position.
        </div>
    @endif

    <div id="map" class="h-[500px] rounded-lg border border-gray-300 mb-4"></div>

    @if(isset($parcelle) && $parcelle->hasLocation())
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 p-4 rounded-md">
                <h3 class="font-bold text-lg mb-2">Détails de la parcelle</h3>
                <p><span class="font-semibold">Nom :</span> {{ $parcelle->nom_parcelle }}</p>
                <p><span class="font-semibold">Type de culture :</span> {{ $parcelle->typeCulture->libelle }}</p>
                <p><span class="font-semibold">Superficie :</span> {{ $parcelle->superficie }} ha</p>
                <p><span class="font-semibold">Date de plantation :</span> {{ \Carbon\Carbon::parse($parcelle->date_plantation)->format('d/m/Y') }}</p>
                <p><span class="font-semibold">Statut :</span> {{ $parcelle->statut }}</p>
                <p><span class="font-semibold">Coordonnées :</span> {{ $parcelle->latitude }}, {{ $parcelle->longitude }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-md">
                <h3 class="font-bold text-lg mb-2">Actions</h3>
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('parcelle.edit', $parcelle->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-center">
                        Modifier cette parcelle
                    </a>
                    <a href="{{ route('intervention.index', ['parcelle_id' => $parcelle->id]) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-center">
                        Voir les interventions
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection

@section('additional_scripts')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Créer la carte
        const map = L.map('map');

        // Ajouter le fond de carte OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Définir l'icône personnalisée pour les parcelles
        const parcelleIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Coordonnées par défaut (France)
        let defaultLat = 46.603354;
        let defaultLng = 1.888334;
        let defaultZoom = 5;

        @if(isset($parcelle) && $parcelle->hasLocation())
            // Centrer la carte sur la parcelle spécifique
            const lat = {{ $parcelle->latitude }};
            const lng = {{ $parcelle->longitude }};

            // Ajouter un marqueur pour cette parcelle
            const marker = L.marker([lat, lng], {icon: parcelleIcon}).addTo(map);
            marker.bindPopup("<b>{{ $parcelle->nom_parcelle }}</b><br>{{ $parcelle->typeCulture->libelle }}<br>{{ $parcelle->superficie }} ha").openPopup();

            // Centrer et zoomer la carte
            map.setView([lat, lng], 13);
        @elseif(isset($parcelles))
            // Tableau pour stocker tous les marqueurs
            const markers = [];

            @foreach($parcelles as $p)
                @if($p->hasLocation())
                    // Ajouter un marqueur pour chaque parcelle avec coordonnées
                    const marker{{ $p->id }} = L.marker([{{ $p->latitude }}, {{ $p->longitude }}], {icon: parcelleIcon}).addTo(map);
                    marker{{ $p->id }}.bindPopup(
                        "<b>{{ $p->nom_parcelle }}</b><br>" +
                        "Type: {{ $p->typeCulture->libelle }}<br>" +
                        "Superficie: {{ $p->superficie }} ha<br>" +
                        "<a href='{{ route('parcelle.map', $p->id) }}' class='text-green-600 hover:underline'>Voir détails</a>"
                    );

                    markers.push(marker{{ $p->id }});
                @endif
            @endforeach

            // S'il y a des marqueurs, ajuster la vue pour les inclure tous
            if (markers.length > 0) {
                const group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            } else {
                // Sinon utiliser la vue par défaut
                map.setView([defaultLat, defaultLng], defaultZoom);
            }
        @else
            // Vue par défaut
            map.setView([defaultLat, defaultLng], defaultZoom);
        @endif
    });
</script>
@endsection
