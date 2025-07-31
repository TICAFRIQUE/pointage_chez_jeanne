<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Historique des pointages - Restaurant chezJeanne</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 20px;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0dcaf0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #0dcaf0;
            color: white;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            color: #fff;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .bg-secondary {
            background-color: #6c757d;
        }

        .bg-primary {
            background-color: #0d6efd;
        }

        .footer {
            margin-top: 20px;
            font-weight: bold;
            font-size: 12px;
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>Historique des pointages — Restaurant chezJeanne</h2>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Employé</th>
                <th>Arrivée</th>
                <th>Départ</th>
                <th>Équipe</th>
                <th>Statut</th>
                <th>Retard (min)</th>
                <th>Modalité</th>
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
                    <td>{{ $heureArrivee ? \Carbon\Carbon::parse($heureArrivee)->format('H:i') : '-' }}</td>
                    <td>{{ $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : '-' }}
                    </td>
                    <td>{{ optional($pointage->equipe)->nom ?? 'Non défini' }}</td>

                    <td>
                        @if ($pointage->modalite === 'jour_travail')
                            @if ($conforme)
                                <span class="badge bg-success">Conforme</span>
                            @elseif ($pointage->heure_arrivee)
                                <span class="badge bg-warning">Retard</span>
                            @else
                                <span class="badge bg-danger"> Absent</span>
                            @endif
                        @else
                            <span class="badge bg-secondary">—</span>
                        @endif
                    </td>

                    <td>{{ $pointage->total_retard * -1 }}</td>

                    <td>
                        @if ($pointage->modalite === 'jour_travail' && $pointage->heure_arrivee)
                            <span class="badge bg-primary"> Présent</span>
                        @elseif ($pointage->modalite === 'pas_jour_travail')
                            <span class="badge bg-secondary"> Repos</span>
                        @else
                            <span class="badge bg-danger">Absent</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (isset($total_retard))
        <div class="footer">
            <strong>Cumul total du retard :</strong> {{ $total_retard * -1 }} minutes
        </div>
    @endif

</body>

</html>
