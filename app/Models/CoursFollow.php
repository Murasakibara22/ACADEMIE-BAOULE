<?php

namespace App\Models;

use App\Models\Cours;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoursFollow extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'cours_id',
        'progession',
        'slug',
    ];

    public function cours() : BelongsTo
    {
        return $this->belongsTo(Cours::class,'cours_id');
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
