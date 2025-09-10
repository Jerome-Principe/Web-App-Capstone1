<?php

namespace App\Http\Controllers;
use App\Models\MedicalForm;
use Illuminate\Http\Request;

class MedicalFormController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalForm::query();

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('emergency_contact', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('relationship', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('emergency_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('smoking_details', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('medication_details', 'LIKE', "%{$searchTerm}%");
            });
        }

        $medicalForms = $query->orderBy('created_at', 'desc')->paginate(10);

        // Append search parameter to pagination links
        if ($request->has('search')) {
            $medicalForms->appends(['search' => $request->search]);
        }

        return view('membership-emergency-medical', ['medicalForms' => $medicalForms]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // List of boolean fields
        $booleanFields = [
            'heart_disease',
            'asthma',
            'gout',
            'cardiovascular_condition',
            'high_blood_pressure',
            'dizziness',
            'arthritis',
            'infectious_disease',
            'black_outs',
            'diabetes',
            'fainting',
            'epilepsy',
            'knees',
            'lower_back',
            'neck',
            'shoulders',
            'hips',
            'pelvis',
            'flexibility'
        ];

        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                // Handle boolean or string representation of boolean values
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            }
        }

        // Save the form data
        $form = MedicalForm::create($data);

        return response()->json($form, 201);
    }

}
