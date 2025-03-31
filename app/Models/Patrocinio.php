<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patrocinio extends Model
{
    use HasFactory;
    protected $table = 'patrocinio';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nome',
        'sigla',
        'logo',
        'link_site',
        'email',
        'contato',
        'endereco',
        'inativo',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'created_at',
        'updated_at',
    ];

    public function entidades():BelongsToMany{
        return $this->belongsToMany(Entidade::class,'entidade_has_patrocinio','patrocinio_id','entidade_id');
    }
}
