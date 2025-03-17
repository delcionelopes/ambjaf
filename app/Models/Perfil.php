<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perfil extends Model
{
    use HasFactory;
    protected $table = 'perfil';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nome',
        'created_at',
        'updated_at',
    ];

    public function autmodope():HasMany{
        return $this->hasMany(Autmodope::class,'perfil_id');
    }

    public function users():HasMany{
        return $this->hasMany(User::class,'perfil_id');
    }
    
}
