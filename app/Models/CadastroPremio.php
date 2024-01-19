<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroPremio extends Model
{
    use HasFactory;
    protected $table = 'cadastro_premios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'premio',
        'descricao',
        'imagem',
        'item',
        'quantidade',
        'total_cadastrado',
        'date',
        'miniatura'
    ];

    public $timestamps = true;
}
