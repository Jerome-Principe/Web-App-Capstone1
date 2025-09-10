<?php

namespace App\Http\Controllers;

use App\Models\MealPlanCustom;
use App\Models\PendingAppointment;
use Illuminate\Http\Request;

class MealPlanCustomController extends Controller
{
    public function index(Request $request)
    {
        $query = MealPlanCustom::with('user'); // Eager-load user relationship

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('category', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('type', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('guideline', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('day', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('breakfast', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('lunch', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('dinner', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('first_name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Apply filters if user_id, category, or type are provided
        if ($request->has('user_id') && $request->input('user_id') !== '') {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('type') && $request->input('type') !== '') {
            $query->where('type', $request->input('type'));
        }

        $mealPlansCustom = $query->orderBy('id', 'desc')->paginate(10);

        // Append search parameter to pagination links
        if ($request->has('search')) {
            $mealPlansCustom->appends(['search' => $request->search]);
        }

        // Fetch approved users
        $approvedUsers = PendingAppointment::where('pending_appointments.status', 'Approved')
            ->join('pending_memberships', 'pending_appointments.user_id', '=', 'pending_memberships.id')
            ->select('pending_memberships.id as user_id', 'pending_memberships.first_name', 'pending_memberships.last_name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->user_id => $item->first_name . ' ' . $item->last_name];
            });

        // Return view for web-based requests
        return view('meal-plan-custom', compact('mealPlansCustom', 'approvedUsers'));
    }


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $approvedUsers = PendingAppointment::where('status', 'Approved')->pluck('user_id')->unique();
            view()->share('approvedUsers', $approvedUsers);

            return $next($request);
        });
    }

    public function mealPlanCustomList()
    {
        $approvedUsers = PendingAppointment::where('status', 'Approved')->pluck('user_id')->unique();

        // Assuming MealPlanCustom is the model for the meal plan data
        $mealPlansCustom = MealPlanCustom::paginate(10);

        return view('meal-plan-custom', compact('mealPlansCustom', 'approvedUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:pending_memberships,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'breakfast' => 'nullable|string',
            'lunch' => 'required|string',
            'dinner' => 'required|string',
            'progress' => 'nullable|in:Incomplete,Completed',
        ]);

        $data = $request->all();
        $data['progress'] = $request->input('progress', 'Incomplete');

        MealPlanCustom::create($data);

        return redirect()->back()->with('success', 'Meal plan Custom item added successfully!');
    }

    public function edit($id)
    {
        $mealPlanCustom = MealPlanCustom::with('user')->findOrFail($id);
        return view('meal-plan-custom-update', compact('mealPlanCustom'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:pending_memberships,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'breakfast' => 'nullable|string',
            'lunch' => 'required|string',
            'dinner' => 'required|string',
            'progress' => 'required|in:Incomplete,Completed',
        ]);

        $mealPlanCustom = MealPlanCustom::findOrFail($id);
        $mealPlanCustom->update($request->all());

        return redirect()->route('meal-plan-custom.index')->with('success', 'Meal plan updated successfully!');
    }

    public function destroy($id)
    {
        $mealPlanCustom = MealPlanCustom::findOrFail($id);
        $mealPlanCustom->delete();

        return redirect()->route('meal-plan-custom.index')->with('success', 'Meal plan deleted successfully!');
    }
}
