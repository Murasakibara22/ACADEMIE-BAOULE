<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Abonnement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'currency_code',
        'type',
        'ref',
        'status',
        'customer_name',
        'customer_phone',
        'taxes',
        'prix_initiale',
        'slug',
        'customer_id',
        'abonnement_id',
    ];

    public function customer() : BelongsTo {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function abonnement() : BelongsTo
    {
        return $this->belongsTo(Abonnement::class,'abonnement_id');
    }
}
