<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentDefect;

use Illuminate\Http\Request;

class EquipmentDefectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $equipmentDefects = EquipmentDefect::with('equipment')->paginate(9);
        return view('inventory-equipments-list-defect', compact('equipmentDefects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $equipments = Equipment::all();
        return view('inventory-equipments-create-defect', compact('equipments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Find the equipment by its ID
        $equipment = Equipment::find($request->equipment_id);

        // Reduce the quantity of the equipment
        if ($equipment->quantity >= $request->quantity) {
            $equipment->quantity -= $request->quantity;
            $equipment->save();

            // Create a new equipment defect record
            EquipmentDefect::create($request->all());

            return redirect()->route('equipments-defect.index')->with('success', 'Defect reported successfully.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Not enough equipment in stock to report this defect.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $equipment = EquipmentDefect::find($id);
        return view('inventory-equipments-update-defect', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the defect and the related equipment
        $equipmentDefect = EquipmentDefect::find($id);
        $equipment = Equipment::find($equipmentDefect->equipment_id);

        // First, restore the original quantity to the equipment
        $equipment->quantity += $equipmentDefect->quantity;

        // Now, update the defect with the new data
        $equipmentDefect->update($request->all());

        // Subtract the new quantity from the equipment
        if ($equipment->quantity >= $request->quantity) {
            $equipment->quantity -= $request->quantity;
            $equipment->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Not enough equipment in stock to update this defect.']);
        }

        return redirect()->route('equipments-defect.index')->with('success', 'Equipment defect updated and quantity adjusted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $equipmentDefect = EquipmentDefect::find($id);
        $equipment = Equipment::find($equipmentDefect->equipment_id);

        // Restore the defect quantity to the equipment
        $equipment->quantity += $equipmentDefect->quantity;
        $equipment->save();

        // Delete the defect record
        $equipmentDefect->delete();

        return redirect()->route('equipments-defect.index')->with('success', 'Defect deleted and quantity restored.');
    }

    // Display a listing of trashed equipment defects
    public function trashed()
    {
        $trashedEquipmentDefects = EquipmentDefect::onlyTrashed()->with('equipment')->paginate(10);
        return view('trashed-equipments-list-defect', compact('trashedEquipmentDefects'));
    }

    // Move selected equipment defects to trash
    public function moveToTrash(Request $request)
    {
        $ids = explode(',', $request->input('selected'));
        EquipmentDefect::whereIn('id', $ids)->delete();

        return redirect()->route('equipments-defect.index')->with('success', 'Selected equipment defects moved to trash.');
    }

    // Restore a single trashed equipment defect
    public function restore($id)
    {
        $equipmentDefect = EquipmentDefect::onlyTrashed()->findOrFail($id);
        $equipmentDefect->restore();

        return redirect()->route('equipments-defect.trashed')->with('success', 'Equipment defect restored successfully.');
    }

    // Restore multiple trashed equipment defects
    public function restoreBulk(Request $request)
    {
        $ids = explode(',', $request->input('selected'));
        EquipmentDefect::onlyTrashed()->whereIn('id', $ids)->restore();

        return redirect()->route('equipments-defect.trashed')->with('success', 'Selected equipment defects restored successfully.');
    }

    // Permanently delete a single trashed equipment defect
    public function forceDelete($id)
    {
        $equipmentDefect = EquipmentDefect::onlyTrashed()->findOrFail($id);
        $equipmentDefect->forceDelete();

        return redirect()->route('equipments-defect.trashed')->with('success', 'Equipment defect permanently deleted.');
    }
}
