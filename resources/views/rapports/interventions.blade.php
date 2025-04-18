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
    </style>
</head>
<body>

<div class="header">
    <table class="header-table">
        <tr>
            <th>
                <h1 style="display: flex; align-items: center; gap: 10px;">
                    <svg width="6px" height="60px" viewBox="0 0 24 24" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000" stroke="#000000" stroke-width="0.01024"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M859.29 140.28c-5.31-15.34-79.28-7-116 9.42s-163.34 116.58-188.52 172-17.35 64.14-30 84.29-17.1 33.3-22.12 27.66-2.24-16.66 7.83-36.5 28-55 32.21-78.58-10.15-111.32-11.56-147.31-15.46-105.8-33.6-106.37-69.25 69.39-75.15 122.11-17.46 139.43 4.21 195.12 34.11 42.14 41.25 66.88-14 82.5-40.95 117.38-37 46.84-48.27 43.18-17-29-9.06-46.76 26.22-37.12 26.48-61.55-9.33-113.22-15.22-136.06S360 291.87 358 272.34s2.85-67.45-10.61-72.41c-23.69-7.57-57.39 50.77-76.1 132.25s6.86 148 15.18 161.37 27.85 46.23 41.65 61.22 25.81 20.89 29.44 46.57 5.44 38.52-9.79 74.66-66.06 149.34-83 166.45c-4.19-42.4 6.47-30.15 7.41-63.57s-3.05-43.81 3-74.05-21.14-139.41-46-168.41c-12.13-15.05-8-53.59-15.32-54.33s-9.44-2.44-13.92 22.33-43 102-34.27 169.44 12.82 73.72 21.86 87.69 21.56 23.3 31.14 50.25 10.82 40.5 20.73 48.44-16.17 92.81-16.17 92.81l28.17 6s24.82-125.4 50.13-137 37.28 17.63 83.27 17.95 103.84-15.91 129.29-26.22 41.21-16.06 66.32-36.4 56.41-67.58 74.87-89.77 31.63-25.58 25.85-33.46-33.3-3.41-61-1.88-114.7 6.52-178.61 29.73-85.12 71.8-96.12 84.38-14.63 27.62-24.49 21.32-4.73-14.71 1.28-23.38 78.23-177 162.4-192.17c40.67-5.8 37.86 24.72 92.36 26s138.9-18.76 202.48-98.5c47.14-59.19 61-113.91 66.63-121s-28.71-13.21-53.39-6.47-35 16.15-58.92 19.32S607 402.11 563.34 443s-47.73 91-66.93 103.09-41.9 25-44.33 17.05 42.39-100.88 78.53-141.68c11.65-13.69 29-5.41 67.11-24.61s144-102.73 174.92-136.36 32.09-58.69 57.77-79.74 30.84-34.75 28.88-40.47z" fill="#73C69A"></path><path d="M207.57 519c-11.4 41.54-7.11 122.14 1.1 161.26s31.48 151.17 31.48 151.17-17-118.18-24.28-165.4-8.3-147.03-8.3-147.03zM322.07 240.56C306.49 289.51 307.36 371 310.53 395s25.7 143.29 39 158.6c-17.27-74.25-28.49-121-33.21-164.41-4.65-43.1-0.32-77.72 5.75-148.63zM641.9 671.54c-33.45 39-103.26 81.1-125.27 91S381.22 816 361.2 812.71c72.25-24.34 117.88-39.36 157.31-58.18 39.09-18.66 66.27-40.53 123.39-82.99zM486 95.61c-10.09 27.71-43.91 204.72-21.09 280.17C450.33 288.82 486 95.61 486 95.61zM792.13 181.21c-39.45 21.42-213.55 167.5-225.74 185.64 33.42-22.3 225.74-185.64 225.74-185.64zM808.82 411.65c-18.6 24.78-170.91 157-273.46 145 159.64-32.19 273.46-145 273.46-145z" fill="#00757F"></path></g></svg>
                    <span>AgiGest</span>
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
    <svg xmlns="http://www.w3.org/2000/svg" width="60" viewBox="0 0 24 24" fill="none"></svg><path d="M859.29 140.28c-5.31-15.34-79.28-7-116 9.42s-163.34 116.58-188.52 172-17.35 64.14-30 
                    84.29-17.1 33.3-22.12 27.66-2.24-16.66 7.83-36.5 28-55 32.21-78.58-10.15-111.32-11.56-147.31-15.46-105.8-33.6-106.37-69.25 69.39-75.15 122.11-17.46 139.43 
                    4.21 195.12 34.11 42.14 41.25 66.88-14 82.5-40.95 117.38-37 46.84-48.27 43.18-17-29-9.06-46.76 26.22-37.12 26.48-61.55-9.33-113.22-15.22-136.06S360 291.87 
                    358 272.34s2.85-67.45-10.61-72.41c-23.69-7.57-57.39 50.77-76.1 132.25s6.86 148 15.18 161.37 27.85 46.23 41.65 61.22 25.81 20.89 29.44 46.57 5.44 38.52-9.79 74.66-66.06 149.34-83 166.45c-4.19-42.4 6.47-30.15 7.41-63.57s-3.05-43.81 3-74.05-21.14-139.41-46-168.41c-12.13-15.05-8-53.59-15.32-54.33s-9.44-2.44-13.92 22.33-43 102-34.27 169.44 12.82 73.72 21.86 87.69 21.56 23.3 31.14 50.25 10.82 40.5 20.73 48.44-16.17 92.81-16.17 92.81l28.17 6s24.82-125.4 50.13-137 37.28 17.63 83.27 17.95 103.84-15.91 129.29-26.22 41.21-16.06 66.32-36.4 56.41-67.58 74.87-89.77 31.63-25.58 25.85-33.46-33.3-3.41-61-1.88-114.7 6.52-178.61 29.73-85.12 71.8-96.12 84.38-14.63 27.62-24.49 21.32-4.73-14.71 1.28-23.38 78.23-177 162.4-192.17c40.67-5.8 37.86 24.72 92.36 26s138.9-18.76 202.48-98.5c47.14-59.19 61-113.91 66.63-121s-28.71-13.21-53.39-6.47-35 16.15-58.92 19.32S607 402.11 563.34 443s-47.73 91-66.93 103.09-41.9 25-44.33 17.05 42.39-100.88 78.53-141.68c11.65-13.69 29-5.41 67.11-24.61s144-102.73 174.92-136.36 32.09-58.69 57.77-79.74 30.84-34.75 28.88-40.47z" fill="#73C69A"></path><path d="M207.57 519c-11.4 41.54-7.11 122.14 1.1 161.26s31.48 151.17 31.48 151.17-17-118.18-24.28-165.4-8.3-147.03-8.3-147.03zM322.07 240.56C306.49 289.51 307.36 371 310.53 395s25.7 143.29 39 158.6c-17.27-74.25-28.49-121-33.21-164.41-4.65-43.1-0.32-77.72 5.75-148.63zM641.9 671.54c-33.45 39-103.26 81.1-125.27 91S381.22 816 361.2 812.71c72.25-24.34 117.88-39.36 157.31-58.18 39.09-18.66 66.27-40.53 123.39-82.99zM486 95.61c-10.09 27.71-43.91 204.72-21.09 280.17C450.33 288.82 486 95.61 486 95.61zM792.13 181.21c-39.45 21.42-213.55 167.5-225.74 185.64 33.42-22.3 225.74-185.64 225.74-185.64zM808.82 411.65c-18.6 24.78-170.91 157-273.46 145 159.64-32.19 273.46-145 273.46-145z" fill="#00757F"></path></g></svg>
</div>

</body>
</html>