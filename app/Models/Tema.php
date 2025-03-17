<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tema extends Model
{
    use HasFactory;    
    use Sluggable;    
    protected $table = 'temas';
    protected $fillable = [
        'titulo',
        'descricao',
        'slug',
        'created_at',
        'updated_at',
    ];

    public function artigos():BelongsToMany{
    return $this->belongsToMany(Artigo::class, 'temas_artigos', 'temas_id','artigos_id');
    }

    public function Sluggable():array{
        return [
                'slug' => [
                    'source' => 'titulo',
                ],
        ];
    }


}
