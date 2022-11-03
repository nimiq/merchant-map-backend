<?php

namespace App\Http\Controllers;

use App\Models\LocationCandidate;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate that the place has valid currencies
        $request->validate([
            'google_place_id' => 'required',
            'currencies' => 'required|array|distinct|exists:App\Models\Currency,symbol'
        ]);

        $currencies = [];

        foreach ($request->currencies as $currency) {
            $currencies[] = \App\Models\Currency::where('symbol', $currency)->first()->id;
        }

        $candidate = new LocationCandidate($request->all());
        $candidate->processed = false; // All candidates created via API are not processed yet
        $candidate->save();

        $candidate->currencies()->attach($currencies);

        return response()->json(['message' => "Issue successfully created."], 201);
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
        return view('candidates.edit', ['candidate' => $locationCandidate]);
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
        $candidate = LocationCandidate::findOrFail($locationCandidate);

        // Validate that the candidate refers to an existing shop and has a valid category
        $request->validate([
            'google_place_id' => 'required',
            'currencies' => 'required|array|distinct|exists:App\Models\Currency,symbol'
        ]);

        $candidate->update($request->all());

        return redirect(route('candidates.show', $candidate->id));
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
}
