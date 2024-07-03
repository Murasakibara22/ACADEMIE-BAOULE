<?php

namespace App\Models;

use App\Models\Offer;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'prix',
        'currency_code',
        'status',
        'date_debut',
        'date_fin',
        'slug',
        'offer_id',
        'customers',
    ];

    public function offer() : BelongsTo
    {
        return $this->belongsTo(Offer::class,'offer_id');
    }

    public function customers()
    {
        $customer_decode =json_decode($this->customers);
        $table_customer = [];
        foreach ($customer_decode as $key => $value) {
            $customer = Customer::where('id',$value)->first();
            $table_customer[] = $customer;
        }
        return $table_customer;
    }

    public function paiement() : BelongsTo {
        return $this->belongsTo(Paiement::class,'abonnement_id');
    }
}
