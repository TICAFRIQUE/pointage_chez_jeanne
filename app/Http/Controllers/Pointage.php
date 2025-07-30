<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresenceRequest;
use App\Models\Employe;
use App\Models\Equipe;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
    // public function equipeActive($date = null)
    // {
    //     $date = $date ?? now()->toDateString();

    //     return $this->equipes()
    //         ->wherePivot('date_affectation', '<=', $date)
    //         ->where(function ($q) use ($date) {
    //             $q->whereNull('date_fin')->orWhere('date_fin', '>=', $date);
    //         })->first();
    // }






    public function store(Request $request)
    {
        // Valider les champs attendus, y compris le tableau 'equipe'

        $validated = $request->validate([
            'date' => 'required|date',
            'heure_arrivee' => 'required|array',
            'heure_depart' => 'required|array',
            'equipe' => 'required|array',
        ]);


        $date = $validated['date'];

        foreach ($validated['heure_arrivee'] as $employe_id => $arrivee) {
            $depart = $validated['heure_depart'][$employe_id] ?? null;
            $equipe_id = $validated['equipe'][$employe_id] ?? null;

            if ($arrivee && $depart && $equipe_id) {
                Presence::create([
                    'employe_id' => $employe_id,
                    'date' => $date,
                    'heure_arrivee' => $arrivee,
                    'heure_depart' => $depart,
                    'equipe_id' => $equipe_id,
                ]);
            }
        }



        return redirect()->route('pointages.listEquipe')
            ->with('success_message', 'Pointage enregistré avec succès.');
    }







    // public function historique()
    // {
    //     $pointages = Presence::with('employe')->orderByDesc('date')->paginate(30);

    //     return view('backend.pages.pointage.historique', compact('pointages'));
    // }





    public function historique(Request $request)
    {
        $query = Presence::with(['employe', 'equipe']);

        // ✅ Filtrage flexible par date
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

        // ✅ Filtre par équipe
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

        return view('backend.pages.pointage.historique_employe', compact('employe', 'pointages'));
    }




    public function exportPdf(Request $request)
    {
        $query = Presence::with(['employe', 'equipe']);

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $dateDebut = Carbon::parse($request->input('date_debut'))->startOfDay();
            $dateFin = Carbon::parse($request->input('date_fin'))->endOfDay();
            $query->whereBetween('date', [$dateDebut, $dateFin]);
        }

        if ($request->filled('equipe_id')) {
            $query->where('equipe_id', $request->input('equipe_id'));
        }

        $pointages = $query->orderByDesc('date')->get();

        $pdf = Pdf::loadView('backend.pages.pointage.pdf', compact('pointages'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('historique_pointages.pdf');
    }
}
