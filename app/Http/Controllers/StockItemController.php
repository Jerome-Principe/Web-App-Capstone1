<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    public function index()
    {
        $stockItems = StockItem::orderBy('id', 'desc')->paginate(9);
        $totalPrice = StockItem::sum('total');

        return view('inventory-stock-items-list', compact('stockItems', 'totalPrice'));
    }

    public function create()
    {
        return view('inventory-stock-items-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $stockItem = StockItem::where('item_name', $request->item_name)->first();

        if ($stockItem) {

            $stockItem->quantity += $request->quantity;
            $stockItem->save();
        } else {

            $stockItem = StockItem::create([
                'item_name' => $request->item_name,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'date' => $request->date,
            ]);
        }

        return redirect()->route('stock-items.index')->with('success', 'Drink item added successfully!');
    }

    public function edit($id)
    {
        $stockItem = StockItem::find($id);
        return view('inventory-stock-items-update', compact('stockItem'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $stockItem = StockItem::findOrFail($id);

        $stockItem->update([
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'date' => $request->date,
        ]);

        \App\Models\SaleItem::where('item_name', $stockItem->item_name)->update(['price' => $request->price]);

        return redirect()->route('stock-items.index')->with('success', 'Stock items updated successfully.');
    }

    public function destroy($id)
    {
        $stockItem = StockItem::findOrFail($id);
        $stockItem->delete();

        return redirect()->route('stock-items.index')->with('success', 'Stock items deleted successfully.');
    }

    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));

        if (!empty($selectedIds)) {
            StockItem::whereIn('id', $selectedIds)->delete();
            return redirect()->route('stock-items.index')->with('success', 'Selected stocks moved to trash.');
        }

        return redirect()->back()->with('error', 'No stocks selected.');
    }

    public function trashed()
    {
        $trashedstockItems = StockItem::onlyTrashed()->paginate(10);
        $totalPrice = 0;

        foreach ($trashedstockItems as $stockItem) {
            $stockItem->total = $stockItem->price * $stockItem->quantity;
            $totalPrice += $stockItem->total;
        }

        return view('trashed-stock-items-list', compact('trashedstockItems', 'totalPrice'));
    }

    public function restoreBulk(Request $request)
    {
        $stockItemIds = explode(',', $request->input('selected'));

        if (empty($stockItemIds)) {
            return back()->with('error', 'Please select at least one Stock to restore.');
        }

        try {
            StockItem::onlyTrashed()->whereIn('id', $stockItemIds)->restore();
            return redirect()->route('stock-items.trashed')->with('success', 'Selected stock restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected stock.');
        }
    }

    public function restore($id)
    {
        try {
            $stockItem = StockItem::onlyTrashed()->findOrFail($id);
            $stockItem->restore();
            return redirect()->route('stock-items.trashed')->with('success', 'Stock restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the stock.');
        }
    }

    public function forceDelete($id)
    {
        try {
            $stockItem = StockItem::onlyTrashed()->findOrFail($id);
            $stockItem->forceDelete();
            return redirect()->route('stock-items.trashed')->with('success', 'Stock permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the stock.');
        }
    }

    public function filterByDate(Request $request)
    {
        $date = $request->input('date');

        $stockItems = StockItem::whereDate('date', $date)->paginate(9);

        $totalPrice = 0;

        foreach ($stockItems as $stockItem) {
            $stockItem->total = $stockItem->price * $stockItem->quantity;
            $totalPrice += $stockItem->total;
        }

        return view('inventory-stock-items-list', compact('stockItems', 'totalPrice'));
    }

    public function exportPdfByDate(Request $request)
    {
        $date = $request->input('date');

        if ($date) {
            $stockItems = StockItem::whereDate('date', $date)->get();
        } else {
            $stockItems = StockItem::all();
        }

        $totalAmount = $stockItems->sum('amount');
        $totalItemNames = $stockItems->count();

        $pdf = Pdf::loadView('inventory-stock-items-pdf', [
            'stockItems' => $stockItems,
            'date' => $date ?? 'All Dates',
            'totalAmount' => $totalAmount,
            'totalItemNames' => $totalItemNames,
        ]);

        return $pdf->download('Inventory Stock Report.pdf');
    }

}
