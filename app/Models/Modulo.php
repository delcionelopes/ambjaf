<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modulo extends Model
{
    use HasFactory;
    protected $table = 'modulo';
    protected $primaryKey = 'codmod';
    protected $fillable = [
        'codmod',
        'nome',
        'imagem',
        'descricao',
        'cor',
        'created_at',
        'updated_at',
    ];

    public function operacoes():BelongsToMany{
        return $this->belongsToMany(Operacao::class,'modope','modulo_codmod','operacao_codope');
    }

     public function autorizacao():HasMany{
        return $this->hasMany(Autmodope::class,'modulo_codmod');
    }
    
}
