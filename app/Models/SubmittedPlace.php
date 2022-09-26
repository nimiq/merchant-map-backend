<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_place_id'
    ];


    /**
     * The currencies supported by this submitted place
     */
    public function currencies()
    {
        return $this->belongsToMany(Currency::class)->withTimestamps();
    }
}
