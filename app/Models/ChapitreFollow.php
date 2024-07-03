<?php

namespace App\Models;

use App\Models\Chapitre;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChapitreFollow extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'chapitre_id',
        'progession',
        'slug',
    ];

    public function chapitre() : BelongsTo
    {
        return $this->belongsTo(Chapitre::class,'chapitre_id');
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
