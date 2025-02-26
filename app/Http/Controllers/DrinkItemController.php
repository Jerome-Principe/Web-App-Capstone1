<?php

namespace App\Http\Controllers;

use App\Models\DrinkItem;
use Illuminate\Http\Request;

class DrinkItemController extends Controller
{
    public function index()
    {
        $drinkItems = DrinkItem::orderBy('id', 'desc')->paginate(9);
        $totalPrice = DrinkItem::sum('total');

        return view('inventory-item-drinks-list', compact('drinkItems', 'totalPrice'));
    }

    public function create()
    {
        return view('inventory-item-drinks-create'); // Keep only one create() method
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        // Check if the drink item already exists
        $drinkItem = DrinkItem::where('item_name', $request->item_name)->first();

        if ($drinkItem) {
            // If it exists, update the quantity
            $drinkItem->quantity += $request->quantity;
            $drinkItem->save();
        } else {
            // If it doesn't exist, create a new entry
            $drinkItem = DrinkItem::create([
                'item_name' => $request->item_name,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'date' => $request->date,
                'time' => $request->time,
            ]);
        }

        return redirect()->route('drinks-item.index')->with('success', 'Drink item added successfully!');
    }



    public function edit($id)
    {
        $drinkItem = DrinkItem::find($id);
        return view('inventory-item-drinks-update', compact('drinkItem'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $drinkItem = DrinkItem::findOrFail($id);

        // Update the DrinkItem price
        $drinkItem->update([
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        // Also update the price in the Drink table for all drinks using this item
        \App\Models\Drink::where('item_name', $drinkItem->item_name)->update(['price' => $request->price]);

        return redirect()->route('drinks-item.index')->with('success', 'Drink item updated successfully.');
    }



    public function destroy($id)
    {
        $drinkItem = DrinkItem::findOrFail($id);
        $drinkItem->delete();

        return redirect()->route('drinks-item.index')->with('success', 'Drink item deleted successfully.');
    }

}
