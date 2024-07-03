<?php

namespace App\Models;

use App\Models\Abonnement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'prix',
        'currency_code',
        'avantages',
        'nb_users',
        'slug',
    ];

    public function abonnements() : HasMany
    {
        return $this->hasMany(Abonnement::class,'offer_id');
    }
}
