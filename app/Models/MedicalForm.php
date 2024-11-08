<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'emergency_contact',
        'relationship',
        'emergency_number',
        'pregnant',
        'weeks_pregnant',
        'physical_activities',
        'smoke_details',
        'medication_details',
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
        'other_condition1',
        'knees',
        'lower_back',
        'neck',
        'shoulders',
        'hips',
        'pelvis',
        'flexibility',
        'other_condition2',
    ];
}
