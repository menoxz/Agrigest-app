<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport des Interventions - {{ $parcelle->nom_parcelle }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .statistics {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-item {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Interventions</h1>
        <h2>Parcelle : {{ $parcelle->nom_parcelle }}</h2>
        <p>Période : {{ $periode['debut'] }} au {{ $periode['fin'] }}</p>
    </div>

    <div class="section">
        <h3 class="section-title">Informations de la Parcelle</h3>
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
                <td>{{ $parcelle->user ? $parcelle->user->name : 'Non assigné' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3 class="section-title">Statistiques Globales</h3>
        <div class="statistics">
            <div class="stat-item">
                <strong>Total des Interventions:</strong> {{ $statistiques['total_interventions'] }}
            </div>
            <div class="stat-item">
                <strong>Interventions Planifiées:</strong> {{ $statistiques['interventions_planifiees'] }}
            </div>
            <div class="stat-item">
                <strong>Interventions Terminées:</strong> {{ $statistiques['interventions_terminees'] }}
            </div>
            <div class="stat-item">
                <strong>Interventions Annulées:</strong> {{ $statistiques['interventions_annulees'] }}
            </div>
            <div class="stat-item">
                <strong>Total des Imprévus:</strong> {{ $statistiques['total_imprevus'] }}
            </div>
            <div class="stat-item">
                <strong>Coût Total:</strong> {{ number_format($statistiques['cout_total'], 2) }} €
            </div>
            <div class="stat-item">
                <strong>Durée Totale:</strong> {{ $statistiques['duree_totale'] }} heures
            </div>
        </div>
    </div>

    <div class="section">
        <h3 class="section-title">Détail des Interventions</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Coût</th>
                    <th>Durée</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interventions as $intervention)
                <tr>
                    <td>{{ $intervention->date_intervention }}</td>
                    <td>{{ $intervention->typeIntervention->nom_type_intervention }}</td>
                    <td>{{ $intervention->description }}</td>
                    <td>{{ $intervention->statut }}</td>
                    <td>{{ number_format($intervention->cout, 2) }} €</td>
                    <td>{{ $intervention->duree }} heures</td>
                </tr>
                @if($intervention->imprevus->count() > 0)
                <tr>
                    <td colspan="6">
                        <strong>Imprévus:</strong>
                        <ul>
                            @foreach($intervention->imprevus as $imprevu)
                            <li>
                                {{ $imprevu->description }} - Impact: {{ $imprevu->impact }}
                                @if($imprevu->solution)
                                - Solution: {{ $imprevu->solution }}
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
