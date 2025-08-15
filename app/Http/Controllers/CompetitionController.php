<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        // Order competitions by creation date, showing newest first
        $competitions = Competition::orderBy('id', 'desc')->paginate(10); // 10 per page

        // Check if the request expects JSON (API) or a view (web)
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $competitions,
            ]);
        }

        // For web requests, return the view
        return view('competition', compact('competitions'));
    }

    public function create()
    {
        return view('competition-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'type_of_competition' => 'required|string',
        ]);

        $competition = Competition::create($validated);

        // Check if the request expects JSON (API) or a view (web)
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Competition record created successfully!',
                'data' => $competition,
            ]);
        }

        // For web requests, redirect back to the competitions page with success message
        return redirect()->back()->with('success', 'Competition record created successfully!');
    }

    public function edit($id)
    {
        $competition = Competition::find($id); // Find the competition by ID
        return view('competition-edit', compact('competition'));
    }

    public function update(Request $request, $id)
    {
        $competition = Competition::find($id); // Find the competition by ID

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'type_of_competition' => 'required|string',
        ]);

        $competition->update($validated);

        // Check if the request expects JSON (API) or a view (web)
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Competition record updated successfully!',
                'data' => $competition,
            ]);
        }

        // For web requests, redirect back to the competitions page with success message
        return redirect()->back()->with('success', 'Competition record updated successfully!');
    }

    public function destroy($id)
    {
        $competition = Competition::find($id); // Find the competition by ID
        $competition->delete(); // Soft delete the competition

        return redirect()->route('competitions.index')->with('success', 'Competition record deleted successfully.');
    }

    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected')); // Parse selected IDs

        if (!empty($selectedIds)) {
            Competition::whereIn('id', $selectedIds)->delete(); // Soft delete the selected competitions
            return redirect()->route('competitions.index')->with('success', 'Selected competitions moved to archived.');
        }

        return redirect()->back()->with('error', 'No competitions selected.');
    }

    public function trashed()
    {
        $trashedCompetitions = Competition::onlyTrashed()->orderBy('id', 'desc')->paginate(10);

        // Check if the request expects JSON (API) or a view (web)
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $trashedCompetitions,
            ]);
        }

        // For web requests, return the view
        return view('trashed-competition', compact('trashedCompetitions'));
    }

    public function restore($trashId)
    {
        try {
            $competition = Competition::onlyTrashed()->findOrFail($trashId); // Find the trashed competition by ID
            $competition->restore(); // Restore the competition

            return redirect()->route('competitions.trashed')->with('success', 'Competition restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the competition.');
        }
    }

    public function restoreBulk(Request $request)
    {
        $competitionIds = explode(',', $request->input('selected')); // Parse selected IDs

        if (empty($competitionIds)) {
            return back()->with('error', 'Please select at least one competition to restore.');
        }

        try {
            Competition::onlyTrashed()->whereIn('id', $competitionIds)->restore(); // Restore selected competitions
            return redirect()->route('competitions.trashed')->with('success', 'Selected competitions restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected competitions.');
        }
    }

    public function forceDelete($trashId)
    {
        $competition = Competition::onlyTrashed()->findOrFail($trashId); // Find the trashed competition by ID
        $competition->forceDelete(); // Permanently delete the competition

        return redirect()->route('competitions.index')->with('success', 'Competition permanently deleted.');
    }

}
