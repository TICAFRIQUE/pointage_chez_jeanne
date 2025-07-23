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
}
