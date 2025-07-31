<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'employe_id',
        'date',
        'heure_arrivee',
        'heure_depart',
        'equipe_id',
        'modalite',
        'total_retard',
    ];


    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }
}
