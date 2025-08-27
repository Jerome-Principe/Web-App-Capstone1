<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
        try {
            $equipment = Equipment::findOrFail($id);

            // The cascading delete will be handled automatically by the model's boot method
            $equipment->delete();

            return redirect()->route('equipmentsAdd.index')->with('success', 'Equipment and all related defect records deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('equipmentsAdd.index')->with('error', 'Failed to delete equipment. Please try again.');
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
            // Use chunking for all equipment to prevent memory issues
            $equipments = collect();
            Equipment::chunk(100, function ($items) use ($equipments) {
                foreach ($items as $item) {
                    $equipments->push($item);
                }
            });
        }

        $pdf = Pdf::loadView('inventory-equipments-pdf', compact('equipments', 'date'));

        return $pdf->download('inventory-equipments-report.pdf');
    }

}
