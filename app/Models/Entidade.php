<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{
    use HasFactory;
    protected $table = "entidade";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'nome',
        'sigla',
        'fundacao',
        'logo',
        'cnpj',
        'email',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'cep',
        'estado',
        'created_at',
        'updated_at',
    ];

    public function patrocinios(){
        return $this->belongsToMany(Patrocinio::class,'entidade_has_patrocinio','entidade_id','patrocinio_id');
    }
}
