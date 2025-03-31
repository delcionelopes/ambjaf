<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Entidade extends Model
{
    use HasFactory;
    protected $table = 'entidade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nome',
        'sigla',
        'fundacao',
        'cnpj',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'cep',
        'estado',
        'created_at',
        'updated_at',
    ];

    protected function patrocinios():BelongsToMany{
        return $this->belongsToMany(Patrocinio::class,'entidade_has_patrocinio','entidade_id','patrocinio_id');
    }
}
