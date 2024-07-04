<?php

namespace App\Models;

use App\Models\Avis;
use App\Models\Like;
use App\Models\Paiement;
use App\Models\Partenaire;
use App\Models\CoursFollow;
use App\Models\SaveChapitre;
use App\Models\ChapitreFollow;
use App\Models\CustomerAdress;
use App\Models\CustomerDevice;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'dial_code',
        'phone_number',
        'phone',
        'email',
        'gender',
        'photo_url',
        'password',
        'code_generate',
        'facebook_id',
        'google_id',
        'slug',
        'CentreInterets',
        'as_partenaire',
        'partenaire_id',
    ];

    public function partenaire() : BelongsTo
    {
        return $this->belongsTo(Partenaire::class,'partenaire_id');
    }

    public function AllAdresses() : HasMany {
        return $this->hasMany(CustomerAdress::class,'customer_id');
    }

    public function FirstAdress() : BelongsTo
    {
        return CustomerAdress::where('customer_id',$this->id)->first();
    }

    public function device() : HasMany {
        return $this->hasMany(CustomerDevice::class,'customer_id');
    }

    public function saveChapitre() : HasMany {
        return $this->hasMany(SaveChapitre::class,'customer_id');
    }

    public function FollowCours() : HasMany {
        return $this->hasMany(CoursFollow::class,'customer_id');
    }

    public function FollwChapitre() : HasMany {
        return $this->hasMany(ChapitreFollow::class,'customer_id');
    }

    public function Paiements() : HasMany {
        return $this->hasMany(Paiement::class,'customer_id');
    }

    public function Likes() : HasMany
    {
        return $this->hasMany(Like::class,'customer_id');
    }

    public function Avis() : HasMany{
        return $this->hasMany(Avis::class,'customer_id');
    }




    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
