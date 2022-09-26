<?php

namespace App\Http\Controllers;

use App\Models\SubmittedPlace;
use Illuminate\Http\Request;

class SubmittedPlaceController extends Controller
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
     * @param  \App\Models\SubmittedPlace  $submittedPlace
     * @return \Illuminate\Http\Response
     */
    public function show(SubmittedPlace $submittedPlace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubmittedPlace  $submittedPlace
     * @return \Illuminate\Http\Response
     */
    public function edit(SubmittedPlace $submittedPlace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubmittedPlace  $submittedPlace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubmittedPlace $submittedPlace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubmittedPlace  $submittedPlace
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubmittedPlace $submittedPlace)
    {
        //
    }
}
