<?php

namespace App\Http\Controllers;
use App\Models\MedicalForm;
use Illuminate\Http\Request;

class MedicalFormController extends Controller
{
    public function index()
    {
        $medicalForms = MedicalForm::paginate(9);
        return view('membership-emergency-medical', ['medicalForms' => $medicalForms]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Convert "yes"/"no" strings to boolean values
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
                $data[$field] = strtolower($data[$field]) === 'yes' ? true : false;
            }
        }

        $form = MedicalForm::create($data);

        return response()->json($form, 201);
    }

}
