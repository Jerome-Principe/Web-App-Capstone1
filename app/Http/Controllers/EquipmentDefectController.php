<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentDefect;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class EquipmentDefectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Order defect-equipment by creation date, showing newest first
        $equipmentDefects = EquipmentDefect::with('equipment')->orderBy('id', 'desc')->paginate(9);
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

            return redirect()->route('equipments-defect.index')->with('success', 'Defect added and quantity updated successfully.');
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

    public function filterByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = $request->input('date');
        $equipmentDefects = EquipmentDefect::whereDate('date', $date)->paginate(9);

        return view('inventory-equipments-list-defect', compact('equipmentDefects'))->with('filteredDate', $date);
    }

    public function exportPdfByDate(Request $request)
    {
        $date = $request->input('date');

        if ($date) {
            $request->validate([
                'date' => 'date',
            ]);
            $equipmentDefects = EquipmentDefect::whereDate('date', $date)->get();
        } else {
            $equipmentDefects = EquipmentDefect::all();
        }

        $pdf = Pdf::loadView('inventory-equipments-defect-pdf', compact('equipmentDefects', 'date'));

        return $pdf->download('inventory-equipments-defect-report.pdf');
    }

    /**
     * Remove the specified equipment defect from the database.
     */
    public function destroy($id)
    {
        try {
            $equipmentDefect = EquipmentDefect::findOrFail($id);

            // The quantity restoration will be handled automatically by the model's boot method
            $equipmentDefect->delete();

            return redirect()->route('equipments-defect.index')->with('success', 'Defect record deleted successfully. Quantity has been restored to the equipment.');
        } catch (\Exception $e) {
            return redirect()->route('equipments-defect.index')->with('error', 'Failed to delete defect record. Please try again.');
        }
    }
}
