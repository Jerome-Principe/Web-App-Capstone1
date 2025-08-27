<?php

namespace App\Http\Controllers;

use App\Models\MachineDefect;
use App\Models\Machine;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class MachineDefectController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        // Order defect-machine by creation date, showing newest first
        $machineDefects = MachineDefect::with('machine')->orderBy('id', 'desc')->paginate(9);
        return view('inventory-machines-list-defect', compact('machineDefects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Use chunking for large machine datasets and disconnect after
        $machineDefects = collect();

        try {
            Machine::chunk(100, function ($machines) use ($machineDefects) {
                foreach ($machines as $machine) {
                    $machineDefects->push($machine);
                }
            });

            // Disconnect to free database connections
            DB::disconnect('mysql');

        } catch (\Exception $e) {
            \Log::error('Database error in MachineDefectController create: ' . $e->getMessage());
            $machineDefects = collect();
        }

        return view('inventory-machines-create-defect', compact('machineDefects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $machine = Machine::find($request->machine_id);

        if ($machine) {
            // Check if there's enough quantity before creating the defect
            if ($machine->quantity >= $request->quantity) {
                // Deduct defect quantity from the machine's available quantity
                $defectQuantity = $request->quantity;
                $machine->quantity -= $defectQuantity;
                $machine->save(); // Update the machine quantity in the database

                // Store the defect information in the `MachineDefect` model
                MachineDefect::create($request->all());

                return redirect()->route('machine-defects.index')->with('success', 'Defect added and quantity updated successfully.');
            } else {
                return redirect()->back()->withErrors(['error' => 'Not enough machine quantity in stock to report this defect.']);
            }
        }

        return redirect()->back()->with('error', 'Machine not found.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $machine = MachineDefect::find($id);
        return view('inventory-machines-update-defect', compact('machine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $machineDefect = MachineDefect::find($id);
        $machine = Machine::find($machineDefect->machine_id);

        if ($machine) {
            // Store the previous defect quantity
            $previousDefectQuantity = $machineDefect->quantity;

            // Restore previous defect quantity back to the machine
            $machine->quantity += $previousDefectQuantity;

            // Check if there's enough quantity before updating
            if ($machine->quantity >= $request->quantity) {
                // Deduct the new defect quantity from the machine
                $machine->quantity -= $request->quantity;

                // Save the updated machine quantity
                $machine->save();

                // Update defect information with the new quantity
                $machineDefect->update($request->all());

                return redirect()->route('machine-defects.index')->with('success', 'Machine defect updated and quantity adjusted successfully.');
            } else {
                // Restore the original quantity since we can't proceed
                $machine->quantity = $machine->quantity - $previousDefectQuantity;
                $machine->save();

                return redirect()->back()->withErrors(['error' => 'Not enough machine quantity in stock to update this defect.']);
            }
        }

        return redirect()->back()->with('error', 'Machine not found.');
    }

    public function filterByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = $request->input('date');
        $machineDefects = MachineDefect::whereDate('date', $date)->paginate(9);

        return view('inventory-machines-list-defect', compact('machineDefects'))->with('filteredDate', $date);
    }

    public function exportPdfByDate(Request $request)
    {
        $date = $request->input('date');

        if ($date) {
            $request->validate([
                'date' => 'date',
            ]);
            $machineDefects = MachineDefect::whereDate('date', $date)->get();
        } else {
            // Use chunking for all machine defects to prevent memory issues
            $machineDefects = collect();
            MachineDefect::chunk(100, function ($defects) use ($machineDefects) {
                foreach ($defects as $defect) {
                    $machineDefects->push($defect);
                }
            });
        }

        $pdf = Pdf::loadView('inventory-machines-defect-pdf', compact('machineDefects', 'date'));

        return $pdf->download('inventory-machines-defect-report.pdf');
    }

    /**
     * Remove the specified machine defect from the database.
     */
    public function destroy($id)
    {
        try {
            $machineDefect = MachineDefect::findOrFail($id);

            // The quantity restoration will be handled automatically by the model's boot method
            $machineDefect->delete();

            return redirect()->route('machine-defects.index')->with('success', 'Defect record deleted successfully. Quantity has been restored to the machine.');
        } catch (\Exception $e) {
            return redirect()->route('machine-defects.index')->with('error', 'Failed to delete defect record. Please try again.');
        }
    }
}
