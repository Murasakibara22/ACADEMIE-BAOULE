<?php

namespace App\Models;

use App\Models\Avis;
use App\Models\Like;
use App\Models\Chapitre;
use App\Models\Parcours;
use App\Models\CoursFollow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cours extends Model
{
    use HasFactory;


    protected $fillable = [
        'libelle',
        'description',
        'langue',
        'nb_like',
        'nb_suivie',
        'nb_heures',
        'info_supp',
        'link_short_video',
        'slug',
        'parcours_id',
    ];


    public function parcours() : BelongsTo
    {
        return $this->belongsTo(Parcours::class,'parcours_id');
    }

    public function chapitres() : HasMany{
        return $this->hasMany(Chapitre::class,'cours_id');
    }

    public function follows() : HasMany {
        return $this->hasMany(CoursFollow::class,'cours_id');
    }

    public function Likes() : HasMany {
        return $this->hasMany(Like::class,'cours_id');
    }

    public function Avis() : HasMany {
        return $this->hasMany(Avis::class,'cours_id');
    }
}
