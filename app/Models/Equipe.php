<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $fillable = [
        'nom',
        'heure_debut',
        'heure_fin',
    ];

    /**
     * Une équipe a plusieurs employés.
     */
    public function employes()
    {
        return $this->hasMany(Employe::class);
    }

    // public function employes()
    // {
    //     return $this->belongsToMany(Employe::class, 'equipe_employe')
    //         ->withPivot('date_affectation', 'date_fin')
    //         ->withTimestamps();
    // }
}
