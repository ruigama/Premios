<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $table = 'premios_supervisor';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'matricula_supervisor',
        'id_premio',
        'disponivel',
        'distribuido',
        'data_recebida'
    ];

    public $timestamps = false;
}
