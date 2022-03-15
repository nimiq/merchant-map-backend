<?php

declare(strict_types=1);

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class BoundingBoxFilter implements Filter
{
    public function __construct($sides)
    {
        if (is_null($sides)) {
            return;
        }

        $sides = collect(explode(',', $sides));
        if ($sides->count() !== 4) {
            throw new \Exception('Expecting 4 sides for bounding box. Got ' . $sides->count());
        }

        $this->sides = $sides->transform(function ($side) {
            return floatval($side);
        });
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereExists(function ($query) {
            $query->from('pickups')
                ->whereRaw("pickups.geo_location && ST_MakeEnvelope(" . $this->sides[0] . ", " . $this->sides[1] . ", " . $this->sides[2] . ", " . $this->sides[3] . ", 4326)")
                ->whereColumn('shops.id', 'pickups.shop_id');
        });
    }
}
