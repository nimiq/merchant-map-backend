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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validated = $request->validate([
            'shop_id' => 'required|exists:\App\Models\Shop,id',
            'issue_category_id' => 'required|exists:App\Models\IssueCategory,id',
        ]);

        $issue = new Issue($request->all());
        $issue->resolved = false; // All issues created via API are not resolved yet
        $issue->save();

        return response()->json(['message' => "Issue successfully created."],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LocationCandidate  $LocationCandidate
     * @return \Illuminate\Http\Response
     */
    public function show(LocationCandidate $LocationCandidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LocationCandidate  $LocationCandidate
     * @return \Illuminate\Http\Response
     */
    public function edit(LocationCandidate $LocationCandidate)
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
    public function update(Request $request, LocationCandidate $LocationCandidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocationCandidate  $LocationCandidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationCandidate $LocationCandidate)
    {
        //
    }
}
