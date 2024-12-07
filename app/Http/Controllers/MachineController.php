<?php

namespace App\Http\Controllers;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $machines = Machine::paginate(9);

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
            'time' => 'required|date_format:H:i',
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

    /**
     * Soft delete selected machines (move to trash).
     */
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));
        if (!empty($selectedIds)) {
            Machine::whereIn('id', $selectedIds)->delete(); // Soft delete the selected machines
            return redirect()->route('machines.index')->with('success', 'Selected machines moved to trash.');
        }

        return redirect()->back()->with('error', 'No machines selected.');
    }

    /**
     * Display the trashed machines (soft deleted).
     */
    public function trashed()
    {
        $trashedMachines = Machine::onlyTrashed()->paginate(10);
        return view('trashed-machines-list', compact('trashedMachines'));
    }

    /**
     * Restore selected machines from trash (soft delete).
     */
    public function restoreBulk(Request $request)
    {
        $machineIds = explode(',', $request->input('selected'));

        if (empty($machineIds)) {
            return back()->with('error', 'Please select at least one machine to restore.');
        }

        try {
            Machine::onlyTrashed()->whereIn('id', $machineIds)->restore();
            return redirect()->route('machines.trashed')->with('success', 'Selected machines restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected machines.');
        }
    }

    /**
     * Restore a single machines from trash (soft delete).
     */
    public function restore($id)
    {
        try {
            $machine = Machine::onlyTrashed()->findOrFail($id);
            $machine->restore();
            return redirect()->route('machine.trashed')->with('success', 'Machine restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the machine.');
        }
    }

    /**
     * Permanently delete a single machines from trash.
     */
    public function forceDelete($id)
    {
        try {
            $machine = Machine::onlyTrashed()->findOrFail($id);
            $machine->forceDelete();
            return redirect()->route('machines.trashed')->with('success', 'machine permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the machine.');
        }
    }
}
