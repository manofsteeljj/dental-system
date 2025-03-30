<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Procedure;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();
        
        $upcomingAppointments = Appointment::with(['patient', 'procedure', 'dentist'])
            ->whereDate('appointment_date', '>=', $today)
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();
            
        $recentPatients = Patient::latest()->take(5)->get();
        
        $monthlyAppointments = Appointment::whereDate('created_at', '>=', $thisMonth)->count();
        
        return view('dashboard', compact(
            'totalPatients',
            'totalAppointments',
            'todayAppointments',
            'upcomingAppointments',
            'recentPatients',
            'monthlyAppointments'
        ));
    }
}
