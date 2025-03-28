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
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nome',
        'ico',
        'descricao',
        'color',
        'created_at',
        'updated_at',
    ];

    public function operacoes():BelongsToMany{
        return $this->belongsToMany(Operacao::class,'modope','modulo_id','operacao_id');
    }

     public function autorizacao():HasMany{
        return $this->hasMany(Autmodope::class,'modulo_id');
    }
    
}
