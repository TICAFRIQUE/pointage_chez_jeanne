<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresenceRequest;
use App\Models\Employe;
use App\Models\Equipe;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Pointage extends Controller
{
    public function listEquipe()
    {

        $equipe = Equipe::all();

        return view('backend.pages.pointage.index', compact('equipe'));
    }

    public function equipeActive($id)
    {
        $equipeActive = Employe::where('equipe_id', $id)->orderBy('nom', 'asc')->get();

        return view('backend.pages.pointage.presencesEmploye', compact('equipeActive'));
    }





    public function store(Request $request)
    {

        $validated = $request->validate([
            'date' => 'required|date',
            'heure_arrivee' => 'required|array',
            'heure_depart' => 'required|array',
        ]);

        $date = $validated['date'];

        foreach ($validated['heure_arrivee'] as $employe_id => $arrivee) {
            $depart = $validated['heure_depart'][$employe_id] ?? null;

            if ($arrivee && $depart) {
                Presence::updateOrCreate(
                    ['employe_id' => $employe_id, 'date' => $date],
                    ['heure_arrivee' => $arrivee, 'heure_depart' => $depart]
                );
            }
        }

        return redirect()->route('pointages.listEquipe')->with('success_message', 'Pointage enregistré avec succès.');
    }



    public function historique()
    {
        $pointages = Presence::with('employe')->orderByDesc('date')->paginate(30);

        return view('backend.pages.pointage.historique', compact('pointages'));
    }
}
