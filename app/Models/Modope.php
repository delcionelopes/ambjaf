<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modope extends Model
{
    use HasFactory;
    protected $table = 'modope';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'modulo_id',
        'operacao_id',
    ];

    public function operacao():BelongsTo{
        return $this->belongsTo(Operacao::class,'operacao_id');
    }

    public function modulo():BelongsTo{
        return $this->belongsTo(Modulo::class,'modulo_id');
    }

}
