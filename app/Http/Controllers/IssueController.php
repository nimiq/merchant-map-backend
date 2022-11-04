<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Shop;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('issues.index', ['issues' => Issue::where('resolved', false)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('issues.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate that the issue refers to an existing shop and has a valid category
        $validated = $request->validate([
            'google_place_id' => 'required|exists:\App\Models\Shop,source_id',
            'issue_category_id' => 'required|exists:App\Models\IssueCategory,id',
            'description' => 'nullable|string',
        ]);

        $shop = Shop::where('source_id', $validated['google_place_id'])->firstOrFail();

        $issue = new Issue();
        $issue->shop_id = $shop->id;
        $issue->issue_category_id = $validated['issue_category_id'];
        $issue->description = $validated['description'];
        $issue->resolved = false; // All issues created via API are not resolved yet
        $issue->save();

        return response()->json(['message' => "Issue successfully created."],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        return view('issues.edit', ['issue' => $issue]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        return view('issues.edit', ['issue' => $issue]);
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
        $issue = Issue::findOrFail($id);

        // Validate that the issue refers to an existing shop and has a valid category
        $validated = $request->validate([
            'google_place_id' => 'required|exists:\App\Models\Shop,source_id',
            'issue_category_id' => 'required|exists:App\Models\IssueCategory,id',
            'description' => 'nullable|string',
        ]);

        $shop = Shop::where('source_id', $validated['google_place_id'])->firstOrFail();

        $issue->shop_id = $shop->id;
        $issue->issue_category_id = $validated['issue_category_id'];
        $issue->description = $validated['description'];
        $issue->save();

        return redirect(route('issues.show', $issue->id));
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect(route('issue.index'));
    }

     /**
     * Mark it as resolve
     *
     * @param  Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function resolve(Request $request, $issueId)
    {
        $issue = Issue::findOrFail($issueId);
        $issue->resolved = true;
        $issue->save();

        return $this->index();
    }
}
