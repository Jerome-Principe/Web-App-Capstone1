<?php

namespace App\Http\Controllers;

use App\Models\Drink;

use Illuminate\Http\Request;

class DrinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all drinks to calculate the total price
        $allDrinks = Drink::all();

        $totalPrice = 0;
        foreach ($allDrinks as $drink) {
            $drink->total = $drink->price * $drink->quantity;
            $totalPrice += $drink->total;
        }

        // Paginate drinks for display (9 items per page)
        $drinks = Drink::paginate(9);

        // Calculate the total for each drink in the paginated data
        foreach ($drinks as $drink) {
            $drink->total = $drink->price * $drink->quantity;
        }

        return view('inventory-drinks-list', compact('drinks', 'totalPrice'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('inventory-drinks-create');
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
            'price' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        Drink::create($request->all());
        return redirect()->route('drinks.index')->with('success', 'Drink added successfully.');
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
    public function edit($id)
    {
        //
        $drink = Drink::find($id);
        return view('inventory-drinks-update', compact('drink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drink $drink)
    {
        //

        $drink->update($request->all());

        return redirect()->route('drinks.index')->with('success', 'Drink updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drink $drink)
    {
        //
        $drink->delete();
        return redirect()->route('drinks.index')->with('success', 'Drink deleted successfully.');
    }
}
