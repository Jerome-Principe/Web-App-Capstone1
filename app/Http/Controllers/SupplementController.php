<?php

namespace App\Http\Controllers;

use App\Models\Supplement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SupplementController extends Controller
{
    /**
     * Display a listing of the supplements.
     * Calculates the total price for all supplements and paginates the list.
     */
    public function index()
    {
        // Paginate supplement and order by creation date (newest first)
        $supplements = Supplement::orderBy('id', 'desc')->paginate(9);

        // Compute total price
        $totalPrice = 0;

        foreach ($supplements as $supplement) {
            // Ensure attributes exist before accessing them
            if (isset($supplement->price, $supplement->quantity)) {
                $supplement->total = $supplement->price * $supplement->quantity;
                $totalPrice += $supplement->total;
            }
        }

        return view('inventory-supplements-list', compact('supplements', 'totalPrice'));
    }

    /**
     * Show the form for creating a new supplement.
     */
    public function create()
    {
        return view('inventory-supplements-create');
    }

    /**
     * Store a newly created supplement in storage.
     * Validates the input data and saves it to the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Supplement::create($request->all());

        return redirect()->route('supplements.index')->with('success', 'Supplement added successfully');
    }

    /**
     * Show the form for editing the specified supplement.
     */
    public function edit(string $id)
    {
        $supplement = Supplement::find($id);

        return view('inventory-supplements-update', compact('supplement'));
    }

    /**
     * Update the specified supplement in storage.
     */
    public function update(Request $request, Supplement $supplement)
    {
        $supplement->update($request->all());

        return redirect()->route('supplements.index')->with('success', 'Supplement updated successfully');
    }

    /**
     * Remove the specified supplement from storage.
     * Performs a soft delete.
     */
    public function destroy(Supplement $supplement)
    {
        $supplement->delete();

        return redirect()->route('supplements.index')->with('success', 'Supplement deleted successfully');
    }

    /**
     * Move selected supplements to trash (soft delete).
     * Accepts a comma-separated list of IDs from the request.
     */
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));

        if (!empty($selectedIds)) {
            Supplement::whereIn('id', $selectedIds)->delete();

            return redirect()->route('supplements.index')->with('success', 'Selected supplements moved to trash.');
        }

        return redirect()->back()->with('error', 'No supplements selected.');
    }

    /**
     * Display a list of trashed supplements (soft-deleted items).
     * Calculates the total price for trashed supplements.
     */
    public function trashed()
    {
        $trashedSupplements = Supplement::onlyTrashed()->paginate(10);

        $totalPrice = 0;
        foreach ($trashedSupplements as $supplement) {
            $supplement->total = $supplement->price * $supplement->quantity;
            $totalPrice += $supplement->total;
        }

        return view('trashed-supplements-list', compact('trashedSupplements', 'totalPrice'));
    }

    /**
     * Restore selected supplements from trash.
     * Accepts a comma-separated list of IDs from the request.
     */
    public function restoreBulk(Request $request)
    {
        $supplementIds = explode(',', $request->input('selected'));

        if (empty($supplementIds)) {
            return back()->with('error', 'Please select at least one supplement to restore.');
        }

        try {
            Supplement::onlyTrashed()->whereIn('id', $supplementIds)->restore();

            return redirect()->route('supplements.trashed')->with('success', 'Selected supplements restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected supplements.');
        }
    }

    /**
     * Restore a single supplement from trash.
     */
    public function restore($id)
    {
        try {
            $supplement = Supplement::onlyTrashed()->findOrFail($id);
            $supplement->restore();

            return redirect()->route('supplements.trashed')->with('success', 'Supplement restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the supplement.');
        }
    }

    /**
     * Permanently delete a single supplement from trash.
     */
    public function forceDelete($id)
    {
        try {
            $supplement = Supplement::onlyTrashed()->findOrFail($id);
            $supplement->forceDelete();

            return redirect()->route('supplements.trashed')->with('success', 'Supplement permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the supplement.');
        }
    }

    public function filterByDate(Request $request)
    {
        $date = $request->input('date');

        // Retrieve supplements filtered by date
        $supplements = Supplement::whereDate('date', $date)->paginate(9);

        // Compute total for each supplement
        $totalPrice = 0;
        foreach ($supplements as $supplement) {
            if (isset($supplement->price, $supplement->quantity)) {
                $supplement->total = $supplement->price * $supplement->quantity;
                $totalPrice += $supplement->total;
            }
        }

        return view('inventory-supplements-list', compact('supplements', 'totalPrice'));
    }



    public function exportPdfByDate(Request $request)
    {
        // Retrieve date from request
        $date = $request->input('date');

        // Check if a date is provided; if not, fetch all records
        if ($date) {
            $supplement = Supplement::whereDate('date', $date)->get();
        } else {
            $supplement = Supplement::all(); // Get all records
        }

        // Calculate totals
        $totalAmount = $supplement->sum(function ($supp) {
            return $supp->price * $supp->quantity;
        });

        $totalItemNames = $supplement->count();

        // Generate the PDF
        $pdf = Pdf::loadView('inventory-supplements-pdf', [
            'supplements' => $supplement,
            'date' => $date ?? 'All Dates',
            'totalAmount' => $totalAmount,
            'totalItemNames' => $totalItemNames,
        ]);

        // Return the PDF for download
        return $pdf->download('inventory-supplements-report.pdf');
    }
}
