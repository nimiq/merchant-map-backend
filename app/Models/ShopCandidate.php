<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id'
    ];

    /**
     * The currencies supported by the shop
     */
    public function currencies()
    {
        return $this->belongsToMany(Currency::class)->withTimestamps();
    }
}
