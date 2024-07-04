<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerAdress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address_name',
        'latitude',
        'customer_id',
        'longitude',
    ];

    public function customer() : BelongsTo {
        return $this->belongsTo(Customer::class);
    }
}
