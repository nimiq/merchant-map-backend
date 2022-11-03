<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\LocationCandidate;

class LocationCandidateProcessorController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $locationCandidate = $request->locationCandidate;
            
            // FIX ME - This is duplicated code from Salamantex Import

            $httpClient = new \GuzzleHttp\Client();
  
            $request = $httpClient->get(
                'https://maps.googleapis.com/maps/api/place/details/json?key='
                . env('GOOGLE_MAPS_GEOCODING_API_KEY') . '&place_id=' . $locationCandidate->google_place_id);
            $body = json_decode($request->getBody()->getContents());

            Log::debug('Request to Google Maps API:');
            Log::debug($body);


            // Get the location information from the API result if available.
            $geo = $body->result->geometry->location ?? (object)array('lat' => 0, 'lng' => 0);

            $body->result->reviews = [];
            if (property_exists($body->result, 'photos')) {
                $body->result->photos = (count($body->result->photos) > 0) ? [$body->result->photos[0]] : [];
            }

            $shop = new Shop($data);
            $shop->user_id = auth()->user()->id;
            $shop->source_id = 'user';
            
            $shop->currencies()->attach($locationCandidate->currencies->pluck('id')->toArray());
            
            $shop->pickups()->create([
                'geo_location' => new Point($geo->lat, $geo->lng),
                'place_id' => $locationCandidate->google_place_id,
                'place_information' => json_encode($body->result)
            ]);

            $shop->save();

            $locationCandidate->processed = true;

            return view('candidates.index', ['candidates' => LocationCandidate::all()]);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage() . $th->getLine() . $th->getFile());
        }
    }
}
