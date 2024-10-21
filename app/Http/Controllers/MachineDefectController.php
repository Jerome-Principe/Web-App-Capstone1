<?php

namespace App\Http\Controllers;

use App\Models\MachineDefect;
use App\Models\Machine;

use Illuminate\Http\Request;

class MachineDefectController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $machineDefects = MachineDefect::with('machine')->paginate(9);
        return view('inventory-machines-list-defect', compact('machineDefects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $machineDefects = Machine::get();
        return view('inventory-machines-create-defect', compact('machineDefects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $machine = Machine::find($request->machine_id);

        if ($machine) {
            // Deduct defect quantity from the machine's available quantity
            $defectQuantity = $request->quantity;
            $machine->quantity -= $defectQuantity;
            $machine->save(); // Update the machine quantity in the database

            // Store the defect information in the `MachineDefect` model
            MachineDefect::create($request->all());

            return redirect()->route('machine-defects.index')->with('success', 'Defect added and quantity updated successfully.');
        }

        return redirect()->back()->with('error', 'Machine not found.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $machineDefect = MachineDefect::find($id);
        return view('inventory-machines-update-defect', compact('machineDefect'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
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

            // Deduct the new defect quantity from the machine
            $machine->quantity -= $request->quantity;

            // Save the updated machine quantity
            $machine->save();

            // Update defect information with the new quantity
            $machineDefect->update($request->all());

            return redirect()->route('machine-defects.index')->with('success', 'Defect updated and machine quantity adjusted.');
        }

        return redirect()->back()->with('error', 'Machine not found.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $machineDefect = MachineDefect::find($id);
        $machineDefect->delete();
        return redirect()->route('machine-defects.index')->with('success', 'Machine deleted successfully');
    }
}
