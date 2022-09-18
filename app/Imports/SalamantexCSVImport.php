<?php

namespace App\Imports;

use App\Models\Shop;
use MStaack\LaravelPostgis\Geometries\Point;
use Illuminate\Support\Facades\Log;

class SalamantexCSVImport
{
    public function __construct($file)
    {
        $csvLines = collect(explode("\n", file_get_contents($file)));
        if (str_contains($csvLines->first(), '_id')) {
            $csvLines->shift();
        }

        if (empty($csvLines->last())) {
            $csvLines->pop();
        }

        $csvLines->transform(function ($line) {
            try {
                $csvArr = str_getcsv($line, ';');
                return (object) [
                    '_id' => $csvArr[0],
                    'partnerNumber' => $csvArr[1],
                    'companyName' => $csvArr[2],
                    'country' => $csvArr[3],
                    'zipCode' => $csvArr[4],
                    'province' => $csvArr[5],
                    'city' => $csvArr[6],
                    'addressLine1' => $csvArr[7],
                    'addressLine2' => $csvArr[8],
                    'addressLine3' => $csvArr[9],
                    'activationDate' => $csvArr[10],
                ];
            } catch (\Throwable $th) {
                Log::warning("Unable to parse CSV line: " . $csvArr);
            }
        });

        $this->csvLines = $csvLines;
    }

    public function import()
    {
        $httpClient = new \GuzzleHttp\Client();

        $this->csvLines->each(function ($line) use (&$httpClient) {
            $shop = Shop::where([
                'source_id' => 'salamantex',
                'object_id' => $line->partnerNumber
            ])->first();

            $data = [
                'label' => $line->companyName,
                'email' => null,
                'description' => null,
                'address_line_1' => $line->addressLine1,
                'address_line_2' => $line->addressLine2,
                'address_line_3' => $line->addressLine3,
                'zip' => $line->zipCode,
                'city' => $line->city,
                'country' => $line->country
            ];

            if (is_null($shop)) {
                $shop = new Shop($data);
                $shop->user_id = auth()->user()->id;
                $shop->object_id = $line->partnerNumber;
                $shop->source_id = 'salamantex';
                $shop->save();

                // FIXME: We probably want to support importing shops that don't accept all currencies in the future.
                $shop->currencies()->attach(\App\Models\Currency::all());
            } else {
                $shop->update($data);
            }

            $shop->pickups()->delete();

            $request = $httpClient->get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json?key=' . env('GOOGLE_MAPS_GEOCODING_API_KEY') . '&inputtype=textquery&input=' . $line->companyName . ' ' . $line->city);
            $body = collect(json_decode($request->getBody()->getContents())->candidates)->first();

            $placeId = $body->place_id ?? null;
            if (is_null($placeId)) {
                Log::warning('Could not find any Place results for: ' . $line->partnerNumber);
                return;
            }

            $request = $httpClient->get('https://maps.googleapis.com/maps/api/place/details/json?key=' . env('GOOGLE_MAPS_GEOCODING_API_KEY') . '&place_id=' . $placeId);
            $body = json_decode($request->getBody()->getContents());

            $geo = $body->result->geometry->location ?? (object)array('lat' => 0, 'lng' => 0);

            $body->result->reviews = [];
            if (property_exists($body->result, 'photos')) {
                $body->result->photos = (count($body->result->photos) > 0) ? [$body->result->photos[0]] : [];
            }

            $shop->pickups()->create([
                'geo_location' => new Point($geo->lat, $geo->lng),
                'place_id' => $placeId,
                'place_information' => json_encode($body->result)
            ]);
        });
    }
}
