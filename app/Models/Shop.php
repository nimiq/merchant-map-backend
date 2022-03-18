<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'description',
        'object_id',
        'source_id',
        'website',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'zip',
        'city',
        'country'
    ];

    protected $hidden = [
        'object_id',
        'source_id',
        'user_id'
    ];

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
