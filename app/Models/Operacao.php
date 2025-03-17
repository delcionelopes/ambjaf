<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operacao extends Model
{
    use HasFactory;
    protected $table = 'operacao';
    protected $primaryKey = 'codope';
    protected $fillable = [
        'codope',
        'nome',
        'imagem',
        'descricao',
        'created_at',
        'updated_at',
    ];

    public function modulos():BelongsToMany{
        return $this->belongsToMany(Modulo::class,'modope','operacao_codope','modulo_codmod');
    }

    public function autorizacao():HasMany{
        return $this->hasMany(Autmodope::class,'operacao_codope');
    }
}
