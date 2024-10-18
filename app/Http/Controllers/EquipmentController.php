<?php

namespace App\Http\Controllers;

use App\Models\Equipment;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $equipments = Equipment::all();
        return view('inventory-equipments-list-add', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('inventory-equipments-create-add');
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

        Equipment::create($request->all());

        return redirect()->route('equipmentsadd.index')->with('success', 'Equipment added successfully.');
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
        $equipment = Equipment::find($id);
        return view('inventory-equipments-update-add', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $equipment = Equipment::findOrFail($id);
        $equipment->update($request->all());
        return redirect()->route('equipmentsadd.index')->with('success', 'Equipment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $equipment = Equipment::find($id);
        $equipment->delete();
        return redirect()->route('equipmentsadd.index')->with('success', 'Equipment deleted successfully.');
    }
}
