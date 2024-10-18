<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use DB;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function submit(Request $request)
    {
        // Validate the form data

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create a new feedback entry
        Feedback::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }

    function feedback()
    {

        $feedback = Feedback::all();

        return view('feedback', compact('feedback'));

    }

    public function index()
    {
        //
        $feedback = Feedback::all(); // compact variable
        return view('feedback', compact('feedback')); // view('bladefile', compact('variable'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Feedback::find($id);
        return view('feedback-update', compact('data'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //Update feedback
        $data = Feedback::find($id);
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->subject = $request->input('subject');
        $data->message = $request->input('message');
        $data->update();

        return redirect()->route('feedback.index')->with('success', 'Feedback updated successfully!');



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $data = Feedback::find($id);
        $data->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback deleted successfully!');


    }
}
