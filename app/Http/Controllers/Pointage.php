<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresenceRequest;
use App\Models\Employe;
use App\Models\Equipe;
use App\Models\Presence;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class Pointage extends Controller
{
    public function listEquipe()
    {

        $equipe = Equipe::all();

        return view('backend.pages.pointage.index', compact('equipe'));
    }

    public function pointageDuJour()
    {
        $pointageDuJour = Employe::orderBy('nom', 'asc')->get();
        $equipes = Equipe::all();

        return view('backend.pages.pointage.presencesEmploye', compact('pointageDuJour', 'equipes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'heure_arrivee' => 'required|array',
            'heure_depart' => 'required|array',
            'equipe' => 'required|array',
            'modalite' => 'required|array',
        ]);

        $date = $validated['date'];

        foreach ($validated['modalite'] as $employe_id => $modalite) {
            $arrivee = $validated['heure_arrivee'][$employe_id] ?? null;
            $depart = $validated['heure_depart'][$employe_id] ?? null;
            $equipe_id = $validated['equipe'][$employe_id] ?? null;

            // On ignore les pointages marqués "pas jour de travail"
            if ($modalite === 'pas_jour_travail') {
                continue;
            }

            $total_retard = 0;

            // Calcul du retard si jour travaillé
            if ($modalite === 'jour_travail' && $arrivee && $equipe_id) {
                $equipe = \App\Models\Equipe::find($equipe_id);

                if ($equipe && $equipe->heure_debut) {
                    $heureArrivee = \Carbon\Carbon::parse($arrivee);
                    $heureDebutEquipe = \Carbon\Carbon::parse($equipe->heure_debut);

                    if ($heureArrivee->gt($heureDebutEquipe)) {
                        $total_retard = $heureArrivee->diffInMinutes($heureDebutEquipe);
                    }
                }
            }

            // Enregistrement de la présence
            Presence::create([
                'employe_id'    => $employe_id,
                'date'          => $date,
                'heure_arrivee' => $modalite === 'jour_travail' ? $arrivee : null,
                'heure_depart'  => $modalite === 'jour_travail' ? $depart : null,
                'equipe_id'     => $equipe_id,
                'modalite'      => $modalite,
                'total_retard'  =>  $total_retard,
            ]);
        }

        return redirect()->route('pointages.listEquipe')
            ->with('success_message', 'Pointage enregistré avec succès.');
    }

    public function historique(Request $request)
    {
        $query = Presence::with(['employe', 'equipe']);

        // Filtrage flexible par date
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $dateDebut = Carbon::parse($request->input('date_debut'))->startOfDay();
            $dateFin = Carbon::parse($request->input('date_fin'))->endOfDay();
            $query->whereBetween('date', [$dateDebut, $dateFin]);
        } elseif ($request->filled('date_debut')) {
            $dateDebut = Carbon::parse($request->input('date_debut'))->startOfDay();
            $query->where('date', '=', $dateDebut);
        } elseif ($request->filled('date_fin')) {
            $dateFin = Carbon::parse($request->input('date_fin'))->endOfDay();
            $query->where('date', '=', $dateFin);
        } else {
            // Par défaut, les 7 derniers jours
            $query->whereBetween('date', [now()->subDays(7)->startOfDay(), now()->endOfDay()]);
        }

        // Filtre par équipe
        if ($request->filled('equipe_id')) {
            $query->where('equipe_id', $request->input('equipe_id'));
        }

        $pointages = $query->orderByDesc('date')->paginate(30);
        $equipes = Equipe::orderBy('nom')->get();




        return view('backend.pages.pointage.historique', compact('pointages', 'equipes'));
    }






    public function historiqueParEmploye(Employe $employe)
    {
        $pointages = $employe->presences()
            ->with('equipe')
            ->orderByDesc('date')
            ->paginate(25);
        $total_retard = $employe->presences()->sum('total_retard') * (-1);

        return view('backend.pages.pointage.historique_employe', compact('employe', 'pointages', 'total_retard'));
    }








  public function exportPdf(Request $request)
{
    $query = Presence::with(['employe', 'equipe']);

    // ✅ Appliquer les mêmes filtres que la vue HTML
    if ($request->filled('date_debut')) {
        $query->whereDate('date', '=', $request->input('date_debut'));
    }

    if ($request->filled('date_fin')) {
        $query->whereDate('date', '=', $request->input('date_fin'));
    }

    if ($request->filled('equipe_id')) {
        $query->where('equipe_id', $request->input('equipe_id'));
    }

    $pointages = $query->orderByDesc('date')->get();
    $total_retard = $pointages->sum('total_retard');

    $pdf = PDF::loadView('backend.pages.pointage.pdf', [
        'pointages' => $pointages,
        'total_retard' => $total_retard,
        'restaurant' => 'chezJeanne',
        'filters' => $request->only(['date_debut', 'date_fin', 'equipe_id']),
    ])->setPaper('A4', 'landscape');

    return $pdf->download('historique_pointages_' . date('Ymd') . '.pdf');
}

}
