<?php

namespace App\Imports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use MStaack\LaravelPostgis\Geometries\Point;
use Spatie\Geocoder\Geocoder;

class SalamantexImport implements SkipsOnFailure, ToModel, WithHeadingRow, WithValidation
{
    use SkipsFailures;

    private function addGeocodingPickup($shop, $data)
    {
        $geocoder = new Geocoder(new \GuzzleHttp\Client());
        $geocoder->setApiKey(config('geocoder.key'));

        try {
            $geo = $geocoder->getCoordinatesForAddress($data['address_line_1'] . ' ' . $data['city']);
            $shop->pickups()->create([
                'geo_location' => new Point($geo['lat'], $geo['lng']),
                'place_id' => $geo['place_id'] ?? null
            ]);
        } catch (\Throwable $th) {
        }
    }

    public function onFailure(Failure ...$failures)
    {
    }

    public function model(array $row)
    {
        if (is_null($row['column1companyname'])) {
            return;
        }

        $shop = Shop::where([
            'source_id' => 'salamantex',
            'object_id' => $row['column1partnernumber']
        ])->first();

        $data = [
            'label' => $row['column1companyname'],
            'email' => $row['column1companymail'],
            'description' => '',
            'address_line_1' => $row['column1addressinfoaddresslines'],
            'zip' => $row['column1addressinfozipcode'],
            'city' => $row['column1addressinfocity'],
            'country' => $row['column1addressinfocountry']
        ];

        if (is_null($shop)) {
            $shop = new Shop($data);
            $shop->user_id = auth()->user()->id;
            $shop->object_id = $row['column1partnernumber'];
            $shop->source_id = 'salamantex';
            $shop->save();
        } else {
            $shop->update($data);
        }

        $shop->pickups()->delete();

        $this->addGeocodingPickup($shop, $data);
    }

    public function rules(): array
    {
        return [
            '1' => \Illuminate\Validation\Rule::unique('column1partnernumber'),
        ];
    }
}
