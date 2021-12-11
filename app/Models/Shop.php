<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public function pickups()
    {
        return $this->hasMany(Pickup::class);
    }

    public function locations()
    {
        return [
            'pickups' => $this->pickups,
            'shippings' => $this->shippings
        ];
    }

    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }
}
