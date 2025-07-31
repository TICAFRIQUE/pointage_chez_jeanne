<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Employe extends Model
{
    protected $fillable = [
        'nom',
        'prenoms',
        'equipe_id',
       
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'equipe_employe')
            ->withPivot('date_affectation', 'date_fin')
            ->withTimestamps();
    }

    public function equipeActive($date = null)
    {
        $date = $date ?? now()->toDateString();

        return $this->equipes()
            ->wherePivot('date_affectation', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('date_fin')->orWhere('date_fin', '>=', $date);
            })
            ->orderByDesc('date_affectation')
            ->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = IdGenerator::generate([
                'table' => 'employes',
                'length' => 10,
                'prefix' => mt_rand(),
            ]);
        });
    }
}
