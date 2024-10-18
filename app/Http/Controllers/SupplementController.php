<?php

namespace App\Http\Controllers;

use App\Models\Supplement;

use Illuminate\Http\Request;

class SupplementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $supplements = Supplement::all();

        $totalPrice = 0;
        foreach ($supplements as $supplement) {
            $supplement->total = $supplement->price * $supplement->quantity;
            $totalPrice = $totalPrice + $supplement->total;
        }

        return view('inventory-supplements-list', compact('supplements', 'totalPrice'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('inventory-supplements-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        Supplement::create($request->all());
        return redirect()->route('supplements.index')->with('success', 'Supplement added successfully');
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
    public function edit(string $id)
    {
        //
        $supplement = Supplement::find($id);
        return view('inventory-supplements-update', compact('supplement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplement $supplement)
    {
        //
        $supplement->update($request->all());
        return redirect()->route('supplements.index')->with('success', 'Supplement updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplement $supplement)
    {
        //
        $supplement->delete();

        return redirect()->route('supplements.index')->with('success', 'Supplement deleted successfully');
    }
}
