<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CompetitionController extends Controller
{
    public function index()
    {
        // Cache competitions for 5 minutes to reduce database connections
        $competitions = Cache::remember('competitions_list', 300, function () {
            return Competition::latest()->paginate(10);
        });

        return view('competition', compact('competitions'));
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

        Competition::create($validated);

        return redirect()->back()->with('success', 'Competition record created successfully!');
    }

    public function update(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'type_of_competition' => 'required|string',
        ]);

        $competition->update($validated);

        return redirect()->back()->with('success', 'Competition record updated successfully!');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();

        return redirect()->back()->with('success', 'Competition record deleted successfully!');
    }

    public function moveToTrash(Request $request)
    {
        $selectedIds = $request->input('selected', '');

        if (empty($selectedIds)) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'No competitions selected'], 400);
            }
            return redirect()->route('competitions.index')->with('error', 'No competitions selected for archiving.');
        }

        // Convert comma-separated string to array
        $selectedIdsArray = explode(',', $selectedIds);

        // Filter out empty values
        $selectedIdsArray = array_filter($selectedIdsArray);

        if (empty($selectedIdsArray)) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'No valid competitions selected'], 400);
            }
            return redirect()->route('competitions.index')->with('error', 'No valid competitions selected for archiving.');
        }

        Competition::whereIn('id', $selectedIdsArray)->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Competitions moved to archive successfully!',
            ]);
        }

        return redirect()->route('competitions.index')->with('success', 'Competitions moved to archive successfully!');
    }

    public function trashed()
    {
        $trashedCompetitions = Competition::onlyTrashed()->orderBy('id', 'desc')->paginate(10);
        return view('trashed-competition', compact('trashedCompetitions'));
    }

    public function restore($id)
    {
        $competition = Competition::onlyTrashed()->findOrFail($id);
        $competition->restore();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Competition restored successfully!',
            ]);
        }

        return redirect()->route('competitions.trashed')->with('success', 'Competition restored successfully!');
    }

    public function restoreBulk(Request $request)
    {
        $selectedIds = explode(',', $request->selected);

        if (empty($selectedIds) || $selectedIds[0] === '') {
            return redirect()->route('competitions.trashed')->with('error', 'No competitions selected for restoration.');
        }

        Competition::onlyTrashed()->whereIn('id', $selectedIds)->restore();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Competitions restored successfully!',
            ]);
        }

        return redirect()->route('competitions.trashed')->with('success', 'Competitions restored successfully!');
    }

    public function forceDelete($id)
    {
        $competition = Competition::onlyTrashed()->findOrFail($id);
        $competition->forceDelete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Competition permanently deleted!',
            ]);
        }

        return redirect()->route('competitions.trashed')->with('success', 'Competition permanently deleted!');
    }
}
