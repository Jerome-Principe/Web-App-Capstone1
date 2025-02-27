<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleItemController extends Controller
{
    public function index()
    {
        $items = SaleItem::orderBy('id', 'desc')->paginate(9);
        $totalPrice = 0;

        foreach ($items as $item) {
            $stockItems = StockItem::where('item_name', $item->item_name)->first();
            if ($stockItems) {
                $item->price = $stockItems->price; // Ensure price is up-to-date
            }
            $item->total = $item->price * $item->quantity;
            $totalPrice += $item->total;
        }

        return view('inventory-sale-items-list', compact('items', 'totalPrice'));
    }

    public function create()
    {
        $stockItems = StockItem::all(); // Fetch all sales items from the database
        return view('inventory-sale-items-create', compact('stockItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $stockItems = StockItem::find($request->item_name);

        if (!$stockItems) {
            return redirect()->back()->with('error', 'Selected sales item not found.');
        }

        if ($stockItems->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        $stockItems->quantity -= $request->quantity;
        $stockItems->save();

        SaleItem::create([
            'item_name' => $stockItems->item_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'date' => $request->date,
        ]);

        return redirect()->route('sales.index')->with('success', 'Sales added successfully.');
    }

    public function edit($id)
    {
        $item = SaleItem::find($id);
        return view('inventory-sale-items-update', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $item = SaleItem::find($id);
        $stockItems = StockItem::where('item_name', $item->item_name)->first();

        if (!$stockItems) {
            return redirect()->back()->with('error', 'Sales item not found in inventory.');
        }

        $quantityDifference = $request->quantity - $item->quantity;

        if ($quantityDifference > 0 && $stockItems->quantity < $quantityDifference) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        $stockItems->quantity -= $quantityDifference;
        $stockItems->save();

        $item->update([
            'quantity' => $request->quantity,
            'price' => $request->price,
            'date' => $request->date,
        ]);

        return redirect()->route('sales.index')->with('success', 'Sales updated successfully.');
    }

    public function destroy($id)
    {
        $item = SaleItem::findOrFail($id);
        $item->delete();
        return redirect()->route('sales.index')->with('success', 'Sales deleted successfully.');
    }

    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));

        if (!empty($selectedIds)) {
            SaleItem::whereIn('id', $selectedIds)->delete();
            return redirect()->route('sales.index')->with('success', 'Selected sales moved to trash.');
        }

        return redirect()->back()->with('error', 'No sales selected.');
    }

    public function trashed()
    {
        $trashedItems = SaleItem::onlyTrashed()->paginate(10);
        $totalPrice = 0;

        foreach ($trashedItems as $item) {
            $item->total = $item->price * $item->quantity;
            $totalPrice += $item->total;
        }

        return view('trashed-sale-items-list', compact('trashedItems', 'totalPrice'));
    }

    public function restoreBulk(Request $request)
    {
        $itemIds = explode(',', $request->input('selected'));

        if (empty($itemIds)) {
            return back()->with('error', 'Please select at least one Sales to restore.');
        }

        try {
            SaleItem::onlyTrashed()->whereIn('id', $itemIds)->restore();
            return redirect()->route('sales.trashed')->with('success', 'Selected sales restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected sales.');
        }
    }

    public function restore($id)
    {
        try {
            $item = SaleItem::onlyTrashed()->findOrFail($id);
            $item->restore();
            return redirect()->route('sales.trashed')->with('success', 'Sales restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the sales.');
        }
    }

    public function forceDelete($id)
    {
        try {
            $item = SaleItem::onlyTrashed()->findOrFail($id);
            $item->forceDelete();
            return redirect()->route('sales.trashed')->with('success', 'Sales permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the sales.');
        }
    }

    public function filterByDate(Request $request)
    {
        $date = $request->input('date');

        $items = SaleItem::whereDate('date', $date)->paginate(9);

        $totalPrice = 0;

        foreach ($items as $item) {
            $item->total = $item->price * $item->quantity;
            $totalPrice += $item->total;
        }

        return view('inventory-sale-items-list', compact('items', 'totalPrice'));
    }

    public function exportPdfByDate(Request $request)
    {
        $date = $request->input('date');

        if ($date) {
            $items = SaleItem::whereDate('date', $date)->get();
        } else {
            $items = SaleItem::all();
        }

        $totalAmount = $items->sum('amount');
        $totalItemNames = $items->count();

        $pdf = Pdf::loadView('inventory-sale-items-pdf', [
            'items' => $items,
            'date' => $date ?? 'All Dates',
            'totalAmount' => $totalAmount,
            'totalItemNames' => $totalItemNames,
        ]);

        return $pdf->download('Inventory Sales Report.pdf');
    }

}
