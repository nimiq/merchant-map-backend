<?php

namespace App\Http\Controllers;

use App\Models\LocationCandidate;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MStaack\LaravelPostgis\Geometries\Point;

class LocationCandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('candidates.index', ['candidates' => LocationCandidate::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('candidates.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * TODO @param bool $ignoreToken - If true, it will ignore the token. This is only for the dashboard.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'google_place_id' => 'bail|required|unique:App\Models\Shop,source_id',
            'token' => 'bail|required',
            'currencies' => 'bail|required|array|distinct|exists:App\Models\Currency,symbol'
        ]);

        if (!$this->verifyToken($request->token)) {
            return response()->json(['error' => 'Unable to verify token.'], 403);
        }
        
        $currencies = [];
        foreach ($request->currencies as $currency) {
            $currencies[] = \App\Models\Currency::where('symbol', $currency)->first()->id;
        }

        $candidate = new LocationCandidate($request->all());
        $candidate->processed = false; // All candidates created via API are not processed yet
        $candidate->save();

        $candidate->currencies()->attach($currencies);

        return response()->json(['message' => "Candidate successfully created."], 201);
    }

    /**
     * Display the specified resource.
     *e
     * @param  \App\Models\LocationCandidate  $LocationCandidate
     * @return \Illuminate\Http\Response
     */
    public function show(LocationCandidate $locationCandidate)
    {
        return view('candidates.edit', ['candidate' => $locationCandidate]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LocationCandidate  $LocationCandidate
     * @return \Illuminate\Http\Response
     */
    public function edit(LocationCandidate $locationCandidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LocationCandidate  $LocationCandidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LocationCandidate $locationCandidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocationCandidate  $LocationCandidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationCandidate $locationCandidate)
    {
        $user = auth()->user();
        if (!$user->is_admin && $locationCandidate->user_id !== $user->id) {
            return redirect(route('shops.index'));
        }

        $locationCandidate->delete();

        return redirect(route('candidates.index'));
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request, $locationCandidateId)
    {
        try {
            $locationCandidate = LocationCandidate::findOrFail($locationCandidateId);
            
            // FIX ME - This is duplicated code from Salamantex Import

            $httpClient = new \GuzzleHttp\Client();
  
            $request = $httpClient->get(
                'https://maps.googleapis.com/maps/api/place/details/json?key='
                . env('GOOGLE_MAPS_GEOCODING_API_KEY') . '&place_id=' . $locationCandidate->google_place_id);
            $body = json_decode($request->getBody()->getContents());

            // Get the location information from the API result if available.
            $geo = $body->result->geometry->location ?? (object)array('lat' => 0, 'lng' => 0);

            $body->result->reviews = [];
            if (property_exists($body->result, 'photos')) {
                $body->result->photos = (count($body->result->photos) > 0) ? [$body->result->photos[0]] : [];
            }

            $street = $this->findAddressComponent($body->result->address_components, 'route');
            $streetNumber = $this->findAddressComponent($body->result->address_components, 'street_number');
            $city = $this->findAddressComponent($body->result->address_components, 'locality');
            $country = $this->findAddressComponent($body->result->address_components, 'country');
            $zipcode = $this->findAddressComponent($body->result->address_components, 'postal_code');

            $data = [
                'label' => $body->result->name,
                'email' => null,
                'description' => null,
                'address_line_1' => ($street->long_name ?? null) . ' ' . ($streetNumber->long_name ?? null),
                'address_line_2' => null,
                'address_line_3' => null,
                'zip' => $zipcode->long_name ?? null,
                'city' => $city->long_name ?? null,
                'country' => $country->short_name ?? null
            ];

            $shop = new Shop($data);
            $shop->user_id = auth()->user()->id;
            // object_id holds the line when the shop was created via CSV. Here it will just store the source.
            $shop->object_id = 'user';
            $shop->source_id = $locationCandidate->google_place_id;

            
            $shop->save();
            $shop->currencies()->attach($locationCandidate->currencies->pluck('id')->toArray());
            $shop->pickups()->create([
                'geo_location' => new Point($geo->lat, $geo->lng),
                'place_id' => $locationCandidate->google_place_id,
                'place_information' => json_encode($body->result)
            ]);

            $locationCandidate->processed = true;
            $locationCandidate->save();

            return view('candidates.index', ['candidates' => LocationCandidate::all()]);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage() . $th->getLine() . $th->getFile());
        }
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

        /**
     * Verifies if the token is valid
     *
     * @param string $token
     * @return boolean
     */
    private function verifyToken($token)
    {

        try {
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            $data = ['secret'  => env('GOOGLE_CAPTCHA_SECRET'), 'response' => $token];
            // We could use `remoteip` as well, it is optional. Should be user's IP, not server's!

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                ]
            ];

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            return json_decode($result)->success;
        }
        catch (Exception $e) {
            return null;
        }
    }
}
