<?php

namespace App\Imports;

use App\Models\Shop;
use MStaack\LaravelPostgis\Geometries\Point;

class PlacesImport
{
    public function __construct($file)
    {
        $csvLines = collect(explode("\n", file_get_contents($file)));
        $csvLines->shift();

        if (empty($csvLines->last())) {
            $csvLines->pop();
        }

        $this->csvLines = $csvLines;
    }

    public function import()
    {
        $httpClient = new \GuzzleHttp\Client();

        $this->csvLines->each(function ($line) use (&$httpClient) {
            try {
                $request = $httpClient->get('https://maps.googleapis.com/maps/api/place/details/json?key=' . env('GOOGLE_MAPS_GEOCODING_API_KEY') . '&place_id=' . $line);
                $body = json_decode($request->getBody()->getContents());

                if ($body->status !== 'OK') {
                    return;
                }

                $body = $body->result;

                $shop = Shop::where([
                    'source_id' => 'dashboard-csv',
                    'object_id' => $line
                ])->first();


                $street = $this->findAddressComponent($body->address_components, 'route');
                $streetNumber = $this->findAddressComponent($body->address_components, 'street_number');
                $city = $this->findAddressComponent($body->address_components, 'locality');
                $country = $this->findAddressComponent($body->address_components, 'country');
                $zipcode = $this->findAddressComponent($body->address_components, 'postal_code');

                $data = [
                    'label' => $body->name,
                    'email' => null,
                    'description' => null,
                    'address_line_1' => ($street->long_name ?? null) . ' ' . ($streetNumber->long_name ?? null),
                    'address_line_2' => null,
                    'address_line_3' => null,
                    'zip' => $zipcode->long_name ?? null,
                    'city' => $city->long_name ?? null,
                    'country' => $country->short_name ?? null
                ];


                if (is_null($shop)) {
                    $shop = new Shop($data);
                    $shop->user_id = auth()->user()->id;
                    $shop->object_id = $line;
                    $shop->source_id = 'dashboard-csv';
                    $shop->save();
                } else {
                    $shop->update($data);
                }

                $shop->pickups()->delete();

                $geo = $body->geometry->location ?? (object)array('lat' => 0, 'lng' => 0);

                $body->reviews = [];
                if (property_exists($body, 'photos')) {
                    $body->photos = (count($body->photos) > 0) ? [$body->photos[0]] : [];
                }

                $shop->pickups()->create([
                    'geo_location' => new Point($geo->lat, $geo->lng),
                    'place_id' => $line,
                    'place_information' => json_encode($body)
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        });
    }

    private function findAddressComponent($components, $type)
    {
        foreach ($components as $comp) {
            foreach ($comp->types as $cType) {
                if ($type === $cType) {
                    return $comp;
                }
            }
        }
        return null;
    }
}
