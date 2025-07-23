<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEquipeRequest;
use Exception;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class EquipeController extends Controller
{
    public function index()
    {

        return view('backend.pages.equipes.index', ['equipes' => Equipe::all()]);
    }

    public function create()
    {

        return view('backend.pages.equipes.create');
    }

    public function store(StoreEquipeRequest $request)
    {

        // Crée une nouvelle équipe avec les données validées
        Equipe::create($request->validated());

        // Redirection avec message de succès
        return redirect()->route('equipes.index')->with('success_message', 'Équipe enregistrée avec succès.');
    }


    public function edit($id)
    {

        $equipe = Equipe::findOrFail($id);

        return view('backend.pages.equipes.edit', ['equipe' => $equipe]);
    }



    public function update(StoreEquipeRequest $request, $id)
    {
        $equipe = Equipe::findOrFail($id);
        $equipe->update($request->validated());

        return redirect()->route('equipes.index')->with('success_message', 'Équipe mise à jour avec succès.');
    }

   public function delete($id){

    $equipe = Equipe::findOrFail($id);
    $equipe->delete();

    return redirect()->route('equipes.index')->with('success_message', 'Équipe supprimée avec succès.');
}

}
