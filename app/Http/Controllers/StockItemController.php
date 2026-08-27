<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Services\CacheService;

class StockItemController extends Controller
{
    public function index()
    {
        $stockItems = StockItem::orderBy('id', 'desc')->paginate(9);
        $totalPrice = StockItem::sum('total');

        // Add information about related sales for each stock item
        foreach ($stockItems as $stockItem) {
            $relatedSalesCount = \App\Models\SaleItem::where('item_name', $stockItem->item_name)->count();
            $stockItem->has_related_sales = $relatedSalesCount > 0;
            $stockItem->related_sales_count = $relatedSalesCount;
        }

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

        // Automatically create an expense record for the stock purchase
        $amount = $request->quantity * $request->price;

        Expense::create([
            'date' => $request->date,
            'category' => 'Monthly expenses',
            'expense_description' => 'Purchased item (' . $request->item_name . ')',
            'amount' => $amount,
            'payment_method' => 'Cash',
        ]);

        return redirect()->route('stock-items.index')->with('success', 'Stock item added successfully!');
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

        // Check if there are any related sale items
        $relatedSales = \App\Models\SaleItem::where('item_name', $stockItem->item_name)->get();

        if ($relatedSales->count() > 0) {
            $saleItemNames = $relatedSales->pluck('item_name')->unique()->implode(', ');
            return redirect()->back()->with('error', 'Cannot delete stock item "' . $stockItem->item_name . '" because it has ' . $relatedSales->count() . ' related sale records. Sale items: ' . $saleItemNames . '. Please delete the sale records first or contact an administrator.');
        }

        $stockItem->delete();
        return redirect()->route('stock-items.index')->with('success', 'Stock item "' . $stockItem->item_name . '" deleted successfully.');
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
