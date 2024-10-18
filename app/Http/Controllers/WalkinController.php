<?php

namespace App\Http\Controllers;

use App\Models\Walkin;

use Illuminate\Http\Request;

class WalkinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $walkins = Walkin::all();

        // Initialize total amount
        $totalAmount = 0;

        // Loop through all walk-ins and sum the amounts
        foreach ($walkins as $walkin) {
            $totalAmount += $walkin->amount;
        }

        return view('walkin-client-list', compact('walkins', 'totalAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('walkin-client-create');


    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        //
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'gender' => 'required|string',
            'age' => 'required|integer|min:1',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'amount' => 'required|numeric',
            'payment' => 'required|string|max:255',
        ]);

        Walkin::create($request->all());
        return redirect()->route('walkin.index')->with('success', 'Client information saved successfully.');

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
        //Edit walkin
        $walkin = Walkin::find($id);
        return view('walkin-client-update', compact('walkin'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //Update Walkin
        $walkin = Walkin::find($id);
        $walkin->update($request->all());

        return redirect()->route('walkin.index')->with('success', 'Walk-in client updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $walkin = Walkin::find($id);
        $walkin->delete();

        return redirect()->route('walkin.index')->with('success', 'Walk-in client deleted successfully.');

    }
}
