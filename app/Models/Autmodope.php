<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Autmodope extends Model
{
    use HasFactory;
    protected $table = 'autmodope';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'operacao_codope',
        'modulo_codmod',
        'modope_id',
        'perfil_id',
        'created_at',
        'updated_at',
    ];

    public function modulo():BelongsTo{
        return $this->belongsTo(Modulo::class,'modulo_codmod');
    }

    public function operacao():BelongsTo{
        return $this->belongsTo(Operacao::class,'operacao_codope');
    }

    public function perfil():BelongsTo{
        return $this->belongsTo(Perfil::class,'perfil_id');        
    }
    
}
