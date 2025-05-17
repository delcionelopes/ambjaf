<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Artigo extends Model
{
    use HasFactory;
    use Sluggable;
    protected $table = "artigos";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'titulo',
        'descricao',
        'conteudo',
        'slug',
        'usuario_id',
        'imagem',
        'created_at',
        'updated_at',
    ];

    public function users(){
        return $this->belongsTo(User::class,'usuario_id','id');
    }

    public function temas():BelongsToMany{
        return $this->belongsToMany(Tema::class,'temas_postagens','artigos_id','temas_id');
    }

    public function arquivos(){
        return $this->hasMany(Arquivo::class,'id','artigos_id');
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class,'id','artigos_id');
    }

    public function patrocinios():BelongsToMany{
        return $this->belongsToMany(Patrocinio::class,'artigos_has_patrocinio','artigos_id','patrocinio_id');
    }

    public function Sluggable():array{
        return [
            'slug' => [
                'source' => 'id',
            ],
        ];
    }

    
}
