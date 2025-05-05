<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'user_id',
        'imagem',
        'created_at',
        'updated_at',
    ];

    public function users():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

    public function temas():BelongsToMany{
        return $this->belongsToMany(Tema::class,'temas_artigos','artigos_id','temas_id');
    }

    public function arquivos():HasMany{
        return $this->hasMany(Arquivo::class,'artigos_id');
    }

    public function comentarios():HasMany{
        return $this->hasMany(Comentario::class,'artigos_id');
    }

    public function patrocinios():BelongsToMany{
        return $this->belongsToMany(Patrocinio::class,'artigos_has_patrocinio','artigos_id','patrocinio_id');
    }

    public function Sluggable():array{
        return [
            'slug' => [
                'source' => 'titulo',
            ],
        ];
    }

    
}
