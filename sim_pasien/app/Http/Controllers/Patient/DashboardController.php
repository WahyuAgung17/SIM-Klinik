<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Models\Patient\Visit;
use App\Models\Patient\PatientControl;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard SIM Pasien';

        $data = [

            'totalPatient' => Patient::count(),

            'activePatient' => Patient::where('status','Aktif')->count(),

            'todayVisit' => Visit::whereDate('visit_date',today())->count(),

            'todayControl' => PatientControl::whereDate('control_date',today())->count(),

            'latestPatients' => Patient::latest()->take(5)->get(),

            'latestVisits' => Visit::latest()->take(5)->get(),

        ];

        return view('patient.dashboard',compact(
            'title',
            'data'
        ));

    }
}