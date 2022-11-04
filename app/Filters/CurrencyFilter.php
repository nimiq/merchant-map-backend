<?php

declare(strict_types=1);

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CurrencyFilter implements Filter
{
    public function __construct($currency)
    {
        if (is_null($currency)) {
            return;
        }
        $this->currency = explode(',', $currency);
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $currArr = $this->currency;

        $query->whereHas('currencies', function ($query) use (&$currArr) {
            $query->from('currencies')
                ->whereIn('currencies.symbol', $currArr);
        });
    }
}
