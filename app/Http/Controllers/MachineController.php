<?php

namespace App\Http\Controllers;
use App\Models\Machine;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Order machine by creation date, showing newest first
        $machines = Machine::orderBy('created_at', 'desc')->paginate(9);

        return view('inventory-machines-list-add', compact('machines')); // Create a view for listing
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('inventory-machines-create-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'date' => 'required|date',
        ]);

        Machine::create($request->all());

        return redirect()->route('machines.index')->with('success', 'Machine added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $machine = Machine::findOrFail($id);
        return view('inventory-machines-update-add', compact('machine')); // Create an update view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $machine = Machine::find($id);
        $machine->update($request->all());

        return redirect()->route('machines.index')->with('success', 'Machine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $machine = Machine::findOrFail($id);
        $machine->delete();
        return redirect()->route('machines.index')->with('success', 'Machine deleted successfully.');
    }



    public function filterByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = $request->input('date');
        $machines = Machine::whereDate('date', $date)->paginate(9);

        return view('inventory-machines-list-add', compact('machines'))->with('filteredDate', $date);
    }

    public function exportPdfByDate(Request $request)
    {
        $date = $request->input('date');

        if ($date) {
            $request->validate([
                'date' => 'date',
            ]);
            $machines = Machine::whereDate('date', $date)->get();
        } else {
            $machines = Machine::all();
        }

        $pdf = Pdf::loadView('inventory-machines-pdf', compact('machines', 'date'));

        return $pdf->download('inventory-machines-report.pdf');
    }
}
