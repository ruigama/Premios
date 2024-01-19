<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    protected $table = 'funcionarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'matricula',
        'id_cargo',
        'matricula_supervisor',
        'id_campanha',
        'id_centro_custo'
    ];

    public $timestamps = false;
}
