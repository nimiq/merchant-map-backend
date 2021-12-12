<?php

namespace App\Http\Controllers;

use App\Filters\LocationFilter;
use App\Filters\VoidFilter;
use App\Models\Shop;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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

        return view('shops.edit', ['shop' => $shop]);
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
        $shop = Shop::findOrFail($id);
        $user = auth()->user();
        if (!$user->is_admin && $shop->user_id !== $user->id) {
            return redirect(route('shops.index'));
        }

        $request->validate([
            'label' => 'required',
            'description' => 'required',
            'email' => 'email:rfc,dns'
        ]);
        $shop->update($request->all());

        return redirect(route('shops.show', $shop->id));
    }

    public function search(Request $request)
    {
        $limit = intval($request->query('filter')['limit'] ?? 20);
        if ($limit === 0) {
            throw new \Exception('Unable to parse limit into int.');
        } else if ($limit > 100) {
            $limit = 100;
        }

        $radius = floatval($request->query('filter')['radius'] ?? 50);
        if ($radius === 0.0) {
            throw new \Exception('Unable to parse radius into float.');
        }

        $shops = QueryBuilder::for(Shop::class)
            ->allowedFilters([
                'city',
                'country',
                'description',
                'email',
                'label',
                'street',
                'number',
                'website',
                'zip',
                AllowedFilter::exact('digital_goods'),
                AllowedFilter::custom('limit', new VoidFilter),
                AllowedFilter::custom('location', new LocationFilter($radius)),
                AllowedFilter::custom('radius', new VoidFilter)
            ])
            ->paginate($limit)
            ->appends(request()->query());


        return $shops;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $user = auth()->user();
        if (!$user->is_admin && $shop->user_id !== $user->id) {
            return redirect(route('shops.index'));
        }

        $shop->delete();

        return redirect(route('shops.index'));
    }
}
