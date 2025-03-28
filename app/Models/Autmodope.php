<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Autmodope extends Model
{
    use HasFactory;
    protected $table = 'autorizacao';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'modope_operacao_id',
        'modope_modulo_id',
        'modope_id',
        'perfil_id',
        'created_at',
        'updated_at',
    ];

    public function modulo():BelongsTo{
        return $this->belongsTo(Modulo::class,'modope_modulo_id');
    }

    public function operacao():BelongsTo{
        return $this->belongsTo(Operacao::class,'modope_operacao_id');
    }

    public function perfil():BelongsTo{
        return $this->belongsTo(Perfil::class,'perfil_id');        
    }
    
}
