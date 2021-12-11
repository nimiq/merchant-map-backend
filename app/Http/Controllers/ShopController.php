<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('shops.index', [
            'shops' => ($user->is_admin) ? Shop::all() : Shop::where('user_id', $user->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shops.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required',
            'description' => 'required',
            'email' => 'email:rfc,dns'
        ]);

        $shop = new Shop($request->all());
        $shop->user_id = auth()->user()->id;
        $shop->save();

        return redirect(route('shops.show', $shop->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $user = auth()->user();
        if (!$user->is_admin && $shop->user_id !== $user->id) {
            return redirect(route('shops.index'));
        }

        return view('shops.show', ['shop' => $shop]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        return view('shops.edit', ['shop' => $shop]);
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
        $request->validate([
            'label' => 'required',
            'description' => 'required',
            'email' => 'email:rfc,dns'
        ]);

        $shop = Shop::findOrFail($id);
        $shop->update($request->request);

        return redirect(route('shops.show', $shop->id));
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
