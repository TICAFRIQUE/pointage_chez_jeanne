<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEquipeRequest;
use Illuminate\Support\Facades\Log;
use Exception;

class EquipeController extends Controller
{
    public function index()
    {
        try {
            $equipes = Equipe::all();
            return view('backend.pages.equipes.index', compact('equipes'));
        } catch (Exception $e) {
            Log::error('Erreur index équipes : ' . $e->getMessage());
            return back()->with('error', 'Impossible de charger la liste des équipes.');
        }
    }

    public function create()
    {
        try {
            return view('backend.pages.equipes.create');
        } catch (Exception $e) {
            Log::error('Erreur create équipe : ' . $e->getMessage());
            return back()->with('error', 'Impossible d\'afficher le formulaire de création.');
        }
    }

    public function store(StoreEquipeRequest $request)
    {
        try {
            Equipe::create($request->validated());
            return redirect()->route('equipes.index')->with('success_message', 'Équipe enregistrée avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur store équipe : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'enregistrement de l\'équipe.');
        }
    }

    public function edit($id)
    {
        try {
            $equipe = Equipe::findOrFail($id);
            return view('backend.pages.equipes.edit', compact('equipe'));
        } catch (Exception $e) {
            Log::error('Erreur edit équipe : ' . $e->getMessage());
            return back()->with('error', 'Équipe introuvable.');
        }
    }

    public function update(StoreEquipeRequest $request, $id)
    {
        try {
            $equipe = Equipe::findOrFail($id);
            $equipe->update($request->validated());
            return redirect()->route('equipes.index')->with('success_message', 'Équipe mise à jour avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur update équipe : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la mise à jour de l\'équipe.');
        }
    }

    public function delete($id)
    {
        try {
            $equipe = Equipe::findOrFail($id);
            $equipe->delete();
            return redirect()->route('equipes.index')->with('success_message', 'Équipe supprimée avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur delete équipe : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la suppression de l\'équipe.');
        }
    }
}
