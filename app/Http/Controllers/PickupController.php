<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use App\Models\Shop;
use Illuminate\Http\Request;
use MStaack\LaravelPostgis\Geometries\Point;

class PickupController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Shop $shop)
    {
        return view('shops.pickups.edit', compact('shop'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shop $shop)
    {
        $user = auth()->user();
        if (!$user->is_admin && $shop->user_id !== $user->id) {
            return redirect(route('shops.index'));
        }

        $request->validate([
            'longtitude' => 'required',
            'latitude' => 'required'
        ]);

        $shop->pickups()->create(
            [
                'geo_location' => new Point($request->latitude, $request->longtitude),
                'label' => $request->label
            ]
        );

        return redirect(route('shops.show', $shop->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop, Pickup $pickup)
    {
        return view('shops.pickups.edit', compact('shop', 'pickup'));
    }

    public function searchByPlaceId($placeId)
    {
        $pickup = Pickup::where('place_id', $placeId)->first();
        if (!$pickup) {
            return response(null, 404);
        }

        $shop = Shop::find($pickup->shop->id);
        $shop->pickups = $shop->pickups;
        $shop->shippings = $shop->shippings;
        $shop->currencies = $shop->currencies;

        return response()->json($shop);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop, Pickup $pickup)
    {
        $user = auth()->user();
        if (!$user->is_admin && $shop->user_id !== $user->id) {
            return redirect(route('shops.index'));
        }

        $request->validate([
            'longtitude' => 'required',
            'latitude' => 'required',
            'place_information' => 'required',
            'place_id' => 'required',
        ]);

        $pickup->update(
            [
                'geo_location' => new Point($request->latitude, $request->longtitude),
                'label' => $request->label,
                'place_information' => $request->place_information,
                'place_id' => $request->place_id,
            ]
        );

        return redirect(route('shops.show', $shop->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop, Pickup $pickup)
    {
        $user = auth()->user();
        if (!$user->is_admin && $shop->user_id !== $user->id) {
            return redirect(route('shops.index'));
        }

        $pickup->delete();
        return redirect(route('shops.show', $shop->id));
    }
}
