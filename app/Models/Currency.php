<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    /**
     * The shops that support this currency
     */
    public function shops()
    {
        return $this->belongsToMany(Shop::class)->withTimestamps();
    }
}