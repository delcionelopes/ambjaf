<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrocinio extends Model
{
    use HasFactory;
    protected $table = "patrocinio";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'nome',
        'sigla',
        'cnpj',
        'cpf',
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

    public function entidades(){
        return $this->belongsToMany(Entidade::class,'entidade_has_patrocinio','patrocinio_id','entidade_id');
    }

    public function artigos(){
        return $this->belongsToMany(Artigo::class,'artigos_has_patrocinio','patrocinio_id','artigos_id');
    }
}
