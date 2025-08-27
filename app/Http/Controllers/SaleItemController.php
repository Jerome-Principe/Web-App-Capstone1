<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
        // Use chunking for large stock datasets and disconnect after
        $stockItems = collect();

        try {
            StockItem::chunk(100, function ($items) use ($stockItems) {
                foreach ($items as $item) {
                    $stockItems->push($item);
                }
            });

            // Disconnect to free database connections
            DB::disconnect('mysql');

        } catch (\Exception $e) {
            \Log::error('Database error in SaleItemController create: ' . $e->getMessage());
            $stockItems = collect();
        }

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
            // Use chunking for all sale items to prevent memory issues
            $items = collect();
            SaleItem::chunk(100, function ($saleItems) use ($items) {
                foreach ($saleItems as $item) {
                    $items->push($item);
                }
            });
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

    public function destroy($id)
    {
        $item = SaleItem::findOrFail($id);

        // Optional: Add business logic validation here
        // For example, check if this sale can be deleted

        $item->delete();
        return redirect()->route('sales.index')->with('success', 'Sale item deleted successfully.');
    }

}
