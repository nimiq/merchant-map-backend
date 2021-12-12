<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Models\Shop;
use Illuminate\Http\Request;
use MStaack\LaravelPostgis\Geometries\Point;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Shop $shop)
    {
        return view('shops.shippings.edit', compact('shop'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shop $shop)
    {
        $request->validate([]);

        $user = auth()->user();
        if (!$user->is_admin && $shop->user_id !== $user->id) {
            return redirect(route('shops.index'));
        }

        $shop->shippings()->create([
            'geo_location' => new Point($request->latitude, $request->longtitude),
            'radius' => $request->radius,
            'countries' => $request->countries
        ]);

        return redirect(route('shops.show', $shop->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop, Shipping $shipping)
    {
        return view('shops.shippings.edit', compact('shop', 'shipping'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
