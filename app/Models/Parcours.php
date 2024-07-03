<?php

namespace App\Models;

use App\Models\Cours;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parcours extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'description',
        'slug',
    ];

    public function cours() : HasMany
    {
        return $this->hasMany(Cours::class,'parcours_id');
    }
}
