<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeRequest;
use App\Models\Employe;
use App\Models\Equipe;
use Exception;
use Illuminate\Http\Request;


class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            $employes = Employe::paginate(10);

            return view('backend.pages.employers.index', compact('employes'));
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error_message', "Erreur survenu lors du chargement de la page employé : " . $e->getMessage());
        }
    }

    public function create()
    {

        return view('backend.pages.employers.create', ['equipes' => Equipe::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeRequest $request)
    {

        $data = $request->all();

        try {
            Employe::create($data);

            return redirect()->route('employes.index')->with('success', "L'employé a été créé avec succès");
        } catch (Exception $e) {

            return "Erreur survenue lors de l'enregistrément de l'employé!" . $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        
        $employe = Employe::findOrFail($id);
        $employe->delete();

        return redirect()->route('employes.index')->with('success_message', 'Employé supprimé avec succès.');
    }
}
