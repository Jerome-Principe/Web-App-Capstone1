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
}
