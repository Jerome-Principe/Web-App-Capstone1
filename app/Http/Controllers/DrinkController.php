<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DrinkController extends Controller
{
    /**
     * Display a listing of the drinks with their total prices.
     */
    public function index()
    {
        // Retrieve all drinks and calculate the total price for all
        $allDrinks = Drink::orderBy('created_at', 'desc')->all(); // Order walk-ins by creation date, showing newest first
        $totalPrice = 0;

        foreach ($allDrinks as $drink) {
            $drink->total = $drink->price * $drink->quantity;
            $totalPrice += $drink->total;
        }

        // Paginate drinks for display (9 items per page)
        $drinks = Drink::paginate(9);

        // Calculate the total for each paginated drink
        foreach ($drinks as $drink) {
            $drink->total = $drink->price * $drink->quantity;
        }

        return view('inventory-drinks-list', compact('drinks', 'totalPrice'));
    }

    /**
     * Show the form for creating a new drink.
     */
    public function create()
    {
        return view('inventory-drinks-create');
    }

    /**
     * Store a newly created drink in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        Drink::create($request->all());
        return redirect()->route('drinks.index')->with('success', 'Drink added successfully.');
    }

    /**
     * Show the form for editing a specific drink.
     */
    public function edit($id)
    {
        $drink = Drink::find($id);
        return view('inventory-drinks-update', compact('drink'));
    }

    /**
     * Update the specified drink in the database.
     */
    public function update(Request $request, Drink $drink)
    {
        $drink->update($request->all());
        return redirect()->route('drinks.index')->with('success', 'Drink updated successfully.');
    }

    /**
     * Remove the specified drink from the database.
     */
    public function destroy(Drink $drink)
    {
        $drink->delete();
        return redirect()->route('drinks.index')->with('success', 'Drink deleted successfully.');
    }

    /**
     * Move selected drinks to the trash (soft delete).
     */
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));

        if (!empty($selectedIds)) {
            Drink::whereIn('id', $selectedIds)->delete();
            return redirect()->route('drinks.index')->with('success', 'Selected drinks moved to trash.');
        }

        return redirect()->back()->with('error', 'No drinks selected.');
    }

    /**
     * Display a list of trashed drinks.
     */
    public function trashed()
    {
        $trashedDrinks = Drink::onlyTrashed()->paginate(10);
        $totalPrice = 0;

        foreach ($trashedDrinks as $drink) {
            $drink->total = $drink->price * $drink->quantity;
            $totalPrice += $drink->total;
        }

        return view('trashed-drinks-list', compact('trashedDrinks', 'totalPrice'));
    }

    /**
     * Restore selected drinks from the trash.
     */
    public function restoreBulk(Request $request)
    {
        $drinkIds = explode(',', $request->input('selected'));

        if (empty($drinkIds)) {
            return back()->with('error', 'Please select at least one drink to restore.');
        }

        try {
            Drink::onlyTrashed()->whereIn('id', $drinkIds)->restore();
            return redirect()->route('drinks.trashed')->with('success', 'Selected drinks restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected drinks.');
        }
    }

    /**
     * Restore a single drink from the trash.
     */
    public function restore($id)
    {
        try {
            $drink = Drink::onlyTrashed()->findOrFail($id);
            $drink->restore();
            return redirect()->route('drinks.trashed')->with('success', 'Drink restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the drink.');
        }
    }

    /**
     * Permanently delete a single drink from the trash.
     */
    public function forceDelete($id)
    {
        try {
            $drink = Drink::onlyTrashed()->findOrFail($id);
            $drink->forceDelete();
            return redirect()->route('drinks.trashed')->with('success', 'Drink permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the drink.');
        }
    }

    public function filterByDate(Request $request)
    {
        $date = $request->input('date');

        // Retrieve drinks based on the selected date
        $drinks = Drink::whereDate('date', $date)->paginate(9);

        // Initialize total price
        $totalPrice = 0;

        // Compute total for each drink
        foreach ($drinks as $drink) {
            $drink->total = $drink->price * $drink->quantity;
            $totalPrice += $drink->total;
        }

        return view('inventory-drinks-list', compact('drinks', 'totalPrice'));
    }


    public function exportPdfByDate(Request $request)
    {
        // Retrieve date from request
        $date = $request->input('date');

        // Check if a date is provided; if not, fetch all records
        if ($date) {
            $drinks = Drink::whereDate('date', $date)->get();
        } else {
            $drinks = Drink::all(); // Get all records
        }

        // Calculate totals
        $totalAmount = $drinks->sum('amount');
        $totalItemNames = $drinks->count();

        // Generate the PDF
        $pdf = Pdf::loadView('inventory-drinks-pdf', [
            'drinks' => $drinks,
            'date' => $date ?? 'All Dates',
            'totalAmount' => $totalAmount,
            'totalItemNames' => $totalItemNames,
        ]);

        // Return the PDF for download
        return $pdf->download('inventory-drinks-report.pdf');
    }

}
