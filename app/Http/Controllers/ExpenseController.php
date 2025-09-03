<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseController extends Controller
{
    // Display a paginated list of expenses with the total amount
    public function index()
    {
        // Order expenses by creation date, showing newest first
        $expenses = Expense::orderBy('id', 'desc')->paginate(10); // 10 per page
        $totalAmount = Expense::sum('amount'); // Calculate total amount of expenses
        $date = null; // Set default date to null for index view

        return view('expenses', compact('expenses', 'totalAmount', 'date'));
    }

    // Store a new expense in the database
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string|in:Monthly expenses,Incident expenses,Utility expenses',
            'expense_description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
        ]);

        // Create the expense
        Expense::create($request->all());

        // Redirect to the index with success message
        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    // Show the form to create a new expense
    public function create()
    {
        return redirect()->route('expenses.index');
    }

    // Show the form to edit an existing expense
    public function edit($id)
    {
        $expense = Expense::findOrFail($id); // Find the expense by ID
        return view('expenses-edit', compact('expense'));
    }

    // Update an existing expense's information
    public function update(Request $request, $id)
    {
        // Validate incoming data
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string|in:Monthly expenses,Incident expenses,Utility expenses',
            'expense_description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
        ]);

        $expense = Expense::findOrFail($id); // Find the expense by ID
        $expense->update($request->all()); // Update the expense data

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    // Soft delete (move to trash) an expense
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id); // Find the expense by ID
        $expense->delete(); // Soft delete the expense

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }

    // Soft delete multiple expenses (bulk move to trash)
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected')); // Parse selected IDs

        if (!empty($selectedIds)) {
            Expense::whereIn('id', $selectedIds)->delete(); // Soft delete the selected expenses
            return redirect()->route('expenses.index')->with('success', 'Selected expenses moved to archived.');
        }

        return redirect()->back()->with('error', 'No expenses selected.');
    }

    // Display a list of soft-deleted (trashed) expenses
    public function trashed()
    {
        $trashedExpenses = Expense::onlyTrashed()->paginate(10); // Paginate trashed expenses
        return view('trashed-expenses', compact('trashedExpenses'));
    }

    // Restore multiple trashed expenses
    public function restoreBulk(Request $request)
    {
        $expenseIds = explode(',', $request->input('selected')); // Parse selected IDs

        if (empty($expenseIds)) {
            return back()->with('error', 'Please select at least one expense to restore.');
        }

        try {
            Expense::onlyTrashed()->whereIn('id', $expenseIds)->restore(); // Restore selected expenses
            return redirect()->route('expenses.trashed')->with('success', 'Selected expenses restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected expenses.');
        }
    }

    // Restore a single trashed expense
    public function restore($id)
    {
        try {
            $expense = Expense::onlyTrashed()->findOrFail($id); // Find the trashed expense by ID
            $expense->restore(); // Restore the expense

            return redirect()->route('expenses.trashed')->with('success', 'Expense restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the expense.');
        }
    }

    // Permanently delete a trashed expense
    public function forceDelete($id)
    {
        $expense = Expense::onlyTrashed()->findOrFail($id); // Find the trashed expense by ID
        $expense->forceDelete(); // Permanently delete the expense

        return redirect()->route('expenses.index')->with('success', 'Expense permanently deleted.');
    }

    // Filter expenses by date
    public function filterByDate(Request $request)
    {
        $date = $request->input('date'); // Get the selected date
        $expenses = Expense::where('date', $date)->paginate(10); // Filter expenses by date
        $totalAmount = Expense::where('date', $date)->sum('amount'); // Calculate the total amount

        return view('expenses', compact('expenses', 'totalAmount', 'date'));
    }

    // Export expenses to PDF
    public function exportPdfByDate(Request $request)
    {
        // Retrieve date from request
        $date = $request->input('date');

        // Check if a date is provided; if not, fetch all records
        if ($date) {
            $expenses = Expense::where('date', $date)->get();
        } else {
            $expenses = Expense::all(); // Get all records
        }

        // Calculate totals
        $totalAmount = $expenses->sum('amount');

        // Generate the PDF
        $pdf = Pdf::loadView('expenses-pdf', [
            'expenses' => $expenses,
            'date' => $date,
            'totalAmount' => $totalAmount,
        ]);

        // Return the PDF for download
        return $pdf->download('expenses-report.pdf');
    }
}
