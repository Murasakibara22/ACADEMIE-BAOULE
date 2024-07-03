<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partenaire extends Model
{
    use HasFactory;

    protected $fillable = [
     'name',
     'dial_code',
     'phone_number',
     'phone',
     'email',
     'logo',
     'password',
     'url'
    ];

    public function customers() : HasMany{
        return $this->hasMany(Customer::class,'partenaire_id');
    }
}
