<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;
    protected $table = "arquivos";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'artigos_id',
        'usuario_id',
        'nome',
        'nomereal',
        'path',
        'created_at',
        'updated_at',
    ];
    public function user(){
        return $this->belongsTo(User::class,'usuario_id','id');
    }
    public function artigo(){
        return $this->belongsTo(Artigo::class,'artigos_id','id');
    }

}
