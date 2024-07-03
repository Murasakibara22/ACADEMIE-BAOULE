<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'firebase_id',
        'device_os',
    ];

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
