<?php

declare(strict_types=1);

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use MStaack\LaravelPostgis\Geometries\Point;

class LocationFilter implements Filter
{
    public function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        if (!is_array($value) || count($value) !== 2) {
            throw new \Exception('Invalid long/lat provided');
        }

        foreach ($value as $key => $geo) {
            $float = floatval($geo);
            if ($float === 0.0) {
                throw new \Exception('Unable to parse provided value into float: ' . $geo);
            }

            $value[$key] = $float;
        }

        // Cast user location to Well-Known Text representation.
        $current_loc = (new Point($value[0], $value[1]))->toWKT();

        // select shops where current user is within the shop radius
        $query->whereExists(function ($query) use ($current_loc) {
            $query->from('shippings')
                ->whereRaw("ST_Distance(
                        ST_GeomFromText('" . $current_loc . "', 4326),
                        geo_location
                     ) <= (radius * 1000)")
                ->whereColumn('shops.id', 'shippings.shop_id');
        });

        //ST_GeogFromText('SRID=4326;POINT(6.100414 52.615886)'),
    }
}
