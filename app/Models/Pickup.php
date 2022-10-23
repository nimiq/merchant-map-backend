<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Pickup extends Model
{
    use HasFactory, PostGisTrait;

    protected $casts = [
        'place_information' => 'object',
    ];

    protected $hidden = ['pivot'];

    protected $fillable = [
        'geo_location',
        'place_id',
        'place_information',
        'label'
    ];

    protected $postgisFields = [
        'geo_location',
    ];

    protected $postgisTypes = [
        'geo_location' => [
            'geomtype' => 'geography',
            'srid' => 4326
        ]
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
