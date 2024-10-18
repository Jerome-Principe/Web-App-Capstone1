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
        $machines = Machine::all();
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
        $machineAdd = Machine::findOrFail($id);
        return view('inventory-machines-update-add', compact('machineAdd')); // Create an update view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $machineAdd = Machine::find($id);
        $machineAdd->update($request->all());

        return redirect()->route('machines.index')->with('success', 'Machine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $machineAdd = Machine::findOrFail($id);
        $machineAdd->delete();
        return redirect()->route('machines.index')->with('success', 'Machine deleted successfully.');
    }
}
