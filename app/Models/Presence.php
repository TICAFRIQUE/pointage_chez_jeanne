<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'employe_id',
        'equipe_id',      
        'heure_arrivee',
        'heure_depart',
        'date',
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
