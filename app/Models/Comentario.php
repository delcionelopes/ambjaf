<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    use HasFactory;
    protected $table = "cometarios";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'artigos_id',
        'usuario_id',
        'texto',
        'created_at',
        'updated_at',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function artigo():BelongsTo{
        return $this->belongsTo(Artigo::class,'artigos_id');
    }
    
}
