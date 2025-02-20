<?php

namespace App\Http\Controllers;
use App\Models\MedicalForm;
use Illuminate\Http\Request;

class MedicalFormController extends Controller
{
    public function index()
    {
        $medicalForms = MedicalForm::orderBy('id', 'desc')->paginate(10);
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
