<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribuicao extends Model
{
    use HasFactory;
    protected $table = 'distribuicao_premios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_premio',
        'matricula_coordenador',
        'quantidade_recebida',
        'quantidade_distribuida',
        'total_recebido',
        'data_recebida',
        'status_recebimento',
        'quantidade_temporaria'
    ];

    public $timestamps = false;
}
