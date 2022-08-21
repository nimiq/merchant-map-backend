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
use Illuminate\Support\Facades\Log;

class SalamantexImport implements SkipsOnFailure, ToModel, WithHeadingRow, WithValidation
{
    use SkipsFailures;

    private function addGeocodingPickup($shop, $data)
    {
        try {
            $httpClient = new \GuzzleHttp\Client();
            $request = $httpClient->get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json?key=' . env('GOOGLE_MAPS_GEOCODING_API_KEY') . '&fields=business_status,formatted_address,geometry,icon,icon_mask_base_uri,icon_background_color,name,photo,place_id,plus_code,type&inputtype=textquery&input=' . $data['label'] . ' ' . $data['address_line_1']);
            $body = collect(json_decode($request->getBody()->getContents())->candidates)->first();

            $placeId = $body->place_id ?? null;
            if (is_null($placeId)) {
                Log::warning('Could not find any Place results for: '.$data['label']);
                return;
            }

            // Get the location information from the API result if available.
            $geo = $body->geometry->location ?? (object)array('lat' => 0, 'lng' => 0);

            if (property_exists($body, 'photos')) {
                $body->photos = (count($body->photos) > 0) ? [$body->photos[0]] : [];
            }

            $shop->pickups()->create([
                'geo_location' => new Point($geo->lat, $geo->lng),
                'place_id' => $placeId,
                'place_information' => json_encode($body)
            ]);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage() . $th->getLine() . $th->getFile());
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
