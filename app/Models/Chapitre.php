<?php

namespace App\Models;

use App\Models\Cours;
use App\Models\SaveChapitre;
use App\Models\ChapitreFollow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'description',
        'cours_id',
        'langue',
        'slug',
        'link_pdf',
        'link_video',
        'images',
    ];

    public function cours() : BelongsTo
    {
        return $this->belongsTo(Cours::class,'cours_id');
    }

    public function saveChapitre() : HasMany
    {
        return $this->belongsTo(SaveChapitre::class,'chapitre_id');
    }

    public function Follow() : HasMany {
        return $this->hasMany(ChapitreFollow::class,'chapitre_id');
    }
}
