<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;
    protected $table = 'premios_colaborador';
    protected $primaryKey = 'id';

    protected $fillable = [
        'matricula',
        'id_premio',
        'quantidade_recebida',
        'status_recebimento',
        'matricula_supervisor',
        'data_recebida'
    ];

    public $timestamps = false;

}
