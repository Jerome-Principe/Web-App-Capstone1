<?php

namespace App\Http\Controllers;

use App\Models\Walkin;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class WalkinController extends Controller
{
    // Display a paginated list of walk-in clients with the total amount
    public function index()
    {
        // Order walk-ins by creation date, showing newest first
        $walkins = Walkin::orderBy('id', 'desc')->paginate(5); // 5 per page
        $totalAmount = Walkin::sum('amount'); // Calculate total amount of walk-ins
        $date = null; // Set default date to null for index view
        $totalNames = $walkins->total(); // Get total count for pagination

        return view('walkin-client-list', compact('walkins', 'totalAmount', 'date', 'totalNames'));
    }

    // Store a new walk-in client in the database
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'gender' => 'required|string',
            'age' => 'required|integer|min:1',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'amount' => 'required|numeric',
            'payment' => 'required|string|max:255',
        ]);

        // Create the walk-in client
        Walkin::create($request->all());

        // Redirect to the index with success message
        return redirect()->route('walkin.index')->with('success', 'Client information saved successfully.');
    }

    // Show the form to create a new walk-in client
    public function create()
    {
        return view('walkin-client-create');
    }

    // Show the form to edit an existing walk-in client
    public function edit($id)
    {
        $walkin = Walkin::find($id); // Find the client by ID
        return view('walkin-client-update', compact('walkin'));
    }

    // Update an existing walk-in client's information
    public function update(Request $request, $id)
    {
        $walkin = Walkin::find($id); // Find the client by ID
        $walkin->update($request->all()); // Update the client data

        return redirect()->route('walkin.index')->with('success', 'Walk-in client updated successfully.');
    }

    // Soft delete (move to trash) a walk-in client
    public function destroy(string $id)
    {
        $walkin = Walkin::find($id); // Find the client by ID
        $walkin->delete(); // Soft delete the client

        return redirect()->route('walkin.index')->with('success', 'Walk-in client deleted successfully.');
    }

    // Soft delete multiple walk-in clients (bulk move to trash)
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected')); // Parse selected IDs

        if (!empty($selectedIds)) {
            Walkin::whereIn('id', $selectedIds)->delete(); // Soft delete the selected clients
            return redirect()->route('walkin.index')->with('success', 'Selected walk-in clients moved to archived.');
        }

        return redirect()->back()->with('error', 'No clients selected.');
    }

    // Display a list of soft-deleted (trashed) walk-in clients
    public function trashed()
    {
        $trashedwalkins = Walkin::onlyTrashed()->paginate(10); // Paginate trashed clients
        return view('trashed-walkin-client-list', compact('trashedwalkins'));
    }

    // Restore multiple trashed walk-in clients
    public function restoreBulk(Request $request)
    {
        $walkinIds = explode(',', $request->input('selected')); // Parse selected IDs

        if (empty($walkinIds)) {
            return back()->with('error', 'Please select at least one client to restore.');
        }

        try {
            Walkin::onlyTrashed()->whereIn('id', $walkinIds)->restore(); // Restore selected clients
            return redirect()->route('walkins.trashed')->with('success', 'Selected walk-in clients restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected walk-in clients.');
        }
    }

    // Restore a single trashed walk-in client
    public function restore($id)
    {
        try {
            $walkin = Walkin::onlyTrashed()->findOrFail($id); // Find the trashed client by ID
            $walkin->restore(); // Restore the client

            return redirect()->route('walkins.trashed')->with('success', 'Walk-in client restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the walk-in client.');
        }
    }

    // Permanently delete a trashed walk-in client
    public function forceDelete($id)
    {
        $walkin = Walkin::onlyTrashed()->findOrFail($id); // Find the trashed client by ID
        $walkin->forceDelete(); // Permanently delete the client

        return redirect()->route('walkin.index')->with('success', 'Walk-in client permanently deleted.');
    }

    public function filterByDate(Request $request)
    {
        $date = $request->input('date'); // Get the selected date
        $walkins = Walkin::whereDate('date', $date)->paginate(9); // Filter walk-ins by date
        $totalAmount = $walkins->sum('amount'); // Calculate the total amount
        $totalNames = $walkins->count(); // Count the total number of names

        return view('walkin-client-list', compact('walkins', 'totalAmount', 'totalNames', 'date'));
    }
    public function exportPdfByDate(Request $request)
    {
        // Retrieve date from request
        $date = $request->input('date');

        // Check if a date is provided; if not, fetch all records
        if ($date) {
            $walkins = Walkin::whereDate('date', $date)->get();
        } else {
            // Use chunking for all walk-ins to prevent memory issues
            $walkins = collect();
            Walkin::chunk(100, function ($items) use ($walkins) {
                foreach ($items as $item) {
                    $walkins->push($item);
                }
            });
        }

        // Calculate totals
        $totalAmount = $walkins->sum('amount');
        $totalNames = $walkins->count();

        // Generate the PDF
        $pdf = Pdf::loadView('walkin-client-pdf', [
            'walkins' => $walkins,
            'date' => $date,
            'totalAmount' => $totalAmount,
            'totalNames' => $totalNames,
        ]);

        // Return the PDF for download
        return $pdf->download('walkin-clients-report.pdf');
    }


}
