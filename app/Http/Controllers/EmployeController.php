<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeRequest;
use App\Models\Employe;
use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class EmployeController extends Controller
{
    /**
     * Affiche la liste paginée des employés.
     */
    public function index()
    {
        try {
            $employes = Employe::paginate(10);
            return view('backend.pages.employers.index', compact('employes'));
        } catch (Exception $e) {
            Log::error("Erreur index employés : " . $e->getMessage());
            return redirect()->back()->with('error_message', "Erreur lors du chargement des employés.");
        }
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        try {
            $equipes = Equipe::all();
            return view('backend.pages.employers.create', compact('equipes'));
        } catch (Exception $e) {
            Log::error("Erreur create employé : " . $e->getMessage());
            return back()->with('error_message', "Impossible d'afficher le formulaire de création.");
        }
    }

    /**
     * Enregistre un nouvel employé.
     */
    public function store(CreateEmployeRequest $request)
    {
        try {
            Employe::create($request->validated());
            return redirect()->route('employes.index')->with('success', "L'employé a été créé avec succès.");
        } catch (Exception $e) {
            Log::error("Erreur store employé : " . $e->getMessage());
            return back()->withInput()->with('error_message', "Erreur lors de l'enregistrement de l'employé.");
        }
    }

    /**
     * Met à jour un employé (à implémenter si nécessaire).
     */
    public function update(Request $request, string $id)
    {
        // À implémenter si besoin.
    }

    /**
     * Supprime un employé.
     */
    public function delete($id)
    {
        try {
            $employe = Employe::findOrFail($id);
            $employe->delete();
            return redirect()->route('employes.index')->with('success_message', 'Employé supprimé avec succès.');
        } catch (Exception $e) {
            Log::error("Erreur delete employé : " . $e->getMessage());
            return redirect()->route('employes.index')->with('error_message', "Erreur lors de la suppression de l'employé.");
        }
    }
}
