<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport d'Intervention - {{ $parcelle->nom_parcelle }}</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #2e7d32;
        }
        .header h2 {
            margin: 10px 0;
            font-size: 20px;
            text-align: left; 
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #555;
            text-align: left; 
        }
        .section {
            border: 1px solid #999;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #e6e6e6;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 16px;
            border-bottom: 1px solid #999;
            margin: -15px -15px 15px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #bbb;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        ul {
            margin: 0;
            padding-left: 20px;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }
        .stat-box {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            background-color: #fafafa;
        }
        .stat-box strong {
            display: block;
            margin-bottom: 5px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
            color: #888;
        }
        .header-table {
            width: 100%;
            border: none;
        }
        .header-table th {
            border: none;
            text-align: center;
        }
        .logo {
    width: 30px; 
    height: auto;
}

    </style>
</head>
<body>

<div class="header">
    <table class="header-table">
        <tr>
            <th>
                <h1 style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ public_path('image/logo.svg') }}" alt="Logo" class="logo">
                    <span>AgriGest</span>
                </h1>
            </th>
            <th>
                <h1>Rapport d’intervention</h1>
            </th>
        </tr>
    </table>
    <h2>Parcelle : {{ $parcelle->nom_parcelle }}</h2>
    <p>Période : {{ $periode['debut'] }} au {{ $periode['fin'] }}</p>
</div>

<div class="section">
    <div class="section-title">Informations de la Parcelle</div>
    <table>
        <tr>
            <th>Surface</th>
            <td>{{ $parcelle->superficie }} m²</td>
        </tr>
        <tr>
            <th>Statut</th>
            <td>{{ $parcelle->statut }}</td>
        </tr>
        <tr>
            <th>Utilisateur Assigné</th>
            <td>{{ Auth::user()->name }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Statistiques Globales</div>
    <table>
        <tr>
            <td>Total des Interventions</td>
            <td>{{ $statistiques['total_interventions'] }}</td>
        </tr>
        <tr>
            <td>Interventions En attente</td>
            <td>{{ $statistiques['interventions_attente'] }}</td>
        </tr>
        <tr>
            <td>Interventions Terminées</td>
            <td>{{ $statistiques['interventions_terminees'] }}</td>
        </tr>
        <tr>
            <td>Interventions En cours</td>
            <td>{{ $statistiques['interventions_actuel'] }}</td>
        </tr>
        <tr>
            <td>Total des Imprévus</td>
            <td>{{ $statistiques['total_imprevus'] }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Détail des Interventions</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Description</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
        @forelse($interventions as $intervention)
            <tr>
                <td>{{ $intervention->date_intervention }}</td>
                <td>{{ $intervention->typeIntervention->libelle}}</td>
                <td>{{ $intervention->description }}</td>
                <td>{{ $intervention->statut_intervention }}</td>
            </tr>
            @if($intervention->imprevus->count() > 0)
            <tr>
                <td colspan="6">
                    <strong>Imprévus :</strong>
                    <ul>
                        @foreach($intervention->imprevus as $imprevu)
                        <li>
                            {{ $imprevu->description }} 
                        </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endif
        @empty
            <tr><td colspan="6" style="text-align:center;">Aucune intervention durant cette période.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="footer">
    Généré  le {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}
    <img src="{{ public_path('image/logo.svg') }}" alt="Logo" class="logo" >
</div>

</body>
</html>