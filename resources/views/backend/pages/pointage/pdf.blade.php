<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Historique des pointages</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .restaurant-name {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        h3 {
            margin: 0.5rem 0 1rem;
            font-size: 15px;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }

        .badge {
            display: inline-block;
            padding: 0.2em 0.4em;
            font-size: 11px;
            font-weight: 600;
            color: white;
            border-radius: 4px;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-danger {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="restaurant-name">Restaurant : chezJeanne</div>
        <h3>Historique des pointages</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Nom & Prénoms</th>
                <th>Heure d’arrivée</th>
                <th>Heure de départ</th>
                <th>Équipe</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pointages as $pointage)
                @php
                    $heureDebut = optional($pointage->equipe)->heure_debut;
                    $heureArrivee = $pointage->heure_arrivee;
                    $conforme =
                        $heureDebut &&
                        $heureArrivee &&
                        \Carbon\Carbon::parse($heureArrivee)->lte(\Carbon\Carbon::parse($heureDebut));
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($pointage->date)->format('d/m/Y') }}</td>
                    <td>{{ $pointage->employe->nom }} {{ $pointage->employe->prenoms }}</td>
                    <td>{{ $pointage->heure_arrivee }}</td>
                    <td>{{ $pointage->heure_depart }}</td>
                    <td>{{ optional($pointage->equipe)->nom ?? 'Non défini' }}</td>
                    <td>
                        @if ($conforme)
                            <span class="badge bg-success">Conforme</span>
                        @else
                            <span class="badge bg-danger">Retard</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
