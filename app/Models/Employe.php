<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Employe extends Model
{
    protected $fillable = [
        'nom',
        'prenoms',
        'equipe_id'
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }



    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'modules', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }
}
