<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the equipment.
     */
    public function index()
    {
        // Order equipment by creation date, showing newest first
        $equipments = Equipment::orderBy('id', 'desc')->paginate(9);
        return view('inventory-equipments-list-add', compact('equipments'));
    }

    /**
     * Show the form for creating a new equipment.
     */
    public function create()
    {
        return view('inventory-equipments-create-add');
    }

    /**
     * Store a newly created equipment in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'date' => 'required|date',
        ]);

        Equipment::create($request->all());
        return redirect()->route('equipmentsAdd.index')->with('success', 'Equipment added successfully.');
    }

    /**
     * Show the form for editing the specified equipment.
     */
    public function edit(string $id)
    {
        $equipment = Equipment::find($id);
        return view('inventory-equipments-update-add', compact('equipment'));
    }

    /**
     * Update the specified equipment in the database.
     */
    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($request->all());
        return redirect()->route('equipmentsAdd.index')->with('success', 'Equipment updated successfully.');
    }

    /**
     * Remove the specified equipment from the database.
     */
    public function destroy($id)
    {
        $equipment = Equipment::find($id);
        $equipment->delete();
        return redirect()->route('equipmentsAdd.index')->with('success', 'Equipment deleted successfully.');
    }

    /**
     * Soft delete selected equipments (move to trash).
     */
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));
        if (!empty($selectedIds)) {
            Equipment::whereIn('id', $selectedIds)->delete(); // Soft delete the selected equipments
            return redirect()->route('equipmentsAdd.index')->with('success', 'Selected equipments moved to trash.');
        }

        return redirect()->back()->with('error', 'No equipments selected.');
    }

    /**
     * Display the trashed equipments (soft deleted).
     */
    public function trashed()
    {
        $trashedEquipments = Equipment::onlyTrashed()->paginate(10);
        return view('trashed-equipments-list', compact('trashedEquipments'));
    }

    /**
     * Restore selected equipments from trash (soft delete).
     */
    public function restoreBulk(Request $request)
    {
        $equipmentIds = explode(',', $request->input('selected'));

        if (empty($equipmentIds)) {
            return back()->with('error', 'Please select at least one equipment to restore.');
        }

        try {
            Equipment::onlyTrashed()->whereIn('id', $equipmentIds)->restore();
            return redirect()->route('equipmentsAdd.trashed')->with('success', 'Selected equipments restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected equipments.');
        }
    }

    /**
     * Restore a single equipment from trash (soft delete).
     */
    public function restore($id)
    {
        try {
            $equipment = Equipment::onlyTrashed()->findOrFail($id);
            $equipment->restore();
            return redirect()->route('equipmentsAdd.trashed')->with('success', 'Equipment restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the equipment.');
        }
    }

    /**
     * Permanently delete a single equipment from trash.
     */
    public function forceDelete($id)
    {
        try {
            $equipment = Equipment::onlyTrashed()->findOrFail($id);
            $equipment->forceDelete();
            return redirect()->route('equipmentsAdd.trashed')->with('success', 'Equipment permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the equipment.');
        }
    }

    public function filterByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = $request->input('date');
        $equipments = Equipment::whereDate('date', $date)->paginate(9);

        return view('inventory-equipments-list-add', compact('equipments'))->with('filteredDate', $date);
    }

    public function exportPdfByDate(Request $request)
    {
        $date = $request->input('date');

        if ($date) {
            $request->validate([
                'date' => 'date',
            ]);

            $equipments = Equipment::whereDate('date', $date)->get();
        } else {
            $equipments = Equipment::all();
        }

        $pdf = Pdf::loadView('inventory-equipments-pdf', compact('equipments', 'date'));

        return $pdf->download('inventory-equipments-report.pdf');
    }

}
