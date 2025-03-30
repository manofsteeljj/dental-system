<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $date = $request->query('date');
        $status = $request->query('status');
        
        $query = Appointment::with(['patient', 'procedure', 'dentist']);
        
        if ($search) {
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        
        if ($date) {
            $query->whereDate('appointment_date', $date);
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $appointments = $query->latest()->paginate(10);
        $statuses = Appointment::getStatusOptions();
        
        return view('appointments.index', compact('appointments', 'search', 'date', 'status', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('last_name')->get();
        $procedures = Procedure::orderBy('name')->get();
        
        // Get dentists (users with dentist role)
        $dentistRole = Role::where('name', 'dentist')->first();
        $dentists = User::where('role_id', $dentistRole->id)->get();
        
        $statuses = Appointment::getStatusOptions();
        
        return view('appointments.create', compact('patients', 'procedures', 'dentists', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'procedure_id' => 'required|exists:procedures,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'status' => 'required|string|in:' . implode(',', array_keys(Appointment::getStatusOptions())),
            'notes' => 'nullable|string',
        ]);
        
        // Format the appointment date and times
        $appointmentDate = $request->appointment_date;
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $appointmentDate . ' ' . $request->start_time);
        
        // Get the procedure to calculate the end time based on duration
        $procedure = Procedure::findOrFail($request->procedure_id);
        $endTime = (clone $startTime)->addMinutes($procedure->duration);
        
        // Check for conflicting appointments
        $conflictingAppointments = Appointment::where('user_id', $request->user_id)
            ->where('appointment_date', $appointmentDate)
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function($q) use ($startTime, $endTime) {
                          $q->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();
            
        if ($conflictingAppointments) {
            return back()->withErrors(['start_time' => 'There is already an appointment scheduled for this time.'])->withInput();
        }
        
        // Create the appointment
        $appointment = new Appointment([
            'patient_id' => $request->patient_id,
            'procedure_id' => $request->procedure_id,
            'user_id' => $request->user_id,
            'appointment_date' => $appointmentDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);
        
        $appointment->save();
        
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'procedure', 'dentist']);
        
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('last_name')->get();
        $procedures = Procedure::orderBy('name')->get();
        
        // Get dentists (users with dentist role)
        $dentistRole = Role::where('name', 'dentist')->first();
        $dentists = User::where('role_id', $dentistRole->id)->get();
        
        $statuses = Appointment::getStatusOptions();
        
        // Format the start time for the form
        $startTime = Carbon::parse($appointment->start_time)->format('H:i');
        
        return view('appointments.edit', compact('appointment', 'patients', 'procedures', 'dentists', 'statuses', 'startTime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'procedure_id' => 'required|exists:procedures,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'status' => 'required|string|in:' . implode(',', array_keys(Appointment::getStatusOptions())),
            'notes' => 'nullable|string',
        ]);
        
        // Format the appointment date and times
        $appointmentDate = $request->appointment_date;
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $appointmentDate . ' ' . $request->start_time);
        
        // Get the procedure to calculate the end time based on duration
        $procedure = Procedure::findOrFail($request->procedure_id);
        $endTime = (clone $startTime)->addMinutes($procedure->duration);
        
        // Check for conflicting appointments (excluding this appointment)
        $conflictingAppointments = Appointment::where('user_id', $request->user_id)
            ->where('appointment_date', $appointmentDate)
            ->where('id', '!=', $appointment->id)
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function($q) use ($startTime, $endTime) {
                          $q->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();
            
        if ($conflictingAppointments) {
            return back()->withErrors(['start_time' => 'There is already an appointment scheduled for this time.'])->withInput();
        }
        
        // Update the appointment
        $appointment->patient_id = $request->patient_id;
        $appointment->procedure_id = $request->procedure_id;
        $appointment->user_id = $request->user_id;
        $appointment->appointment_date = $appointmentDate;
        $appointment->start_time = $startTime;
        $appointment->end_time = $endTime;
        $appointment->status = $request->status;
        $appointment->notes = $request->notes;
        
        $appointment->save();
        
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}
