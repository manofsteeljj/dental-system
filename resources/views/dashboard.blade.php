<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Patients Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="bg-mint-100 p-3 rounded-full mr-4">
                            <svg class="h-8 w-8 text-dental-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Patients</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalPatients }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Appointments Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="bg-mint-100 p-3 rounded-full mr-4">
                            <svg class="h-8 w-8 text-dental-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Appointments</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalAppointments }}</p>
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="bg-mint-100 p-3 rounded-full mr-4">
                            <svg class="h-8 w-8 text-dental-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Today's Appointments</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $todayAppointments }}</p>
                        </div>
                    </div>
                </div>

                <!-- Monthly Appointments Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="bg-mint-100 p-3 rounded-full mr-4">
                            <svg class="h-8 w-8 text-dental-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Monthly Appointments</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $monthlyAppointments }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Upcoming Appointments -->
                <div class="lg:col-span-2">
                    <x-card>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Upcoming Appointments</h3>
                            <a href="{{ route('appointments.index') }}" class="text-sm text-dental-primary hover:text-dental-secondary">View All</a>
                        </div>

                        @if($upcomingAppointments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Procedure</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($upcomingAppointments as $appointment)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->full_name }}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-700">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-700">{{ $appointment->start_time->format('h:i A') }}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-700">{{ $appointment->procedure->name }}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($appointment->status == 'scheduled') bg-blue-100 text-blue-800
                                                        @elseif($appointment->status == 'confirmed') bg-green-100 text-green-800
                                                        @elseif($appointment->status == 'cancelled') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-gray-500 py-4 text-center">No upcoming appointments</div>
                        @endif
                    </x-card>
                </div>

                <!-- Recent Patients -->
                <div>
                    <x-card>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Patients</h3>
                            <a href="{{ route('patients.index') }}" class="text-sm text-dental-primary hover:text-dental-secondary">View All</a>
                        </div>

                        @if($recentPatients->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentPatients as $patient)
                                    <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg">
                                        <div class="bg-mint-100 h-10 w-10 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-dental-primary font-semibold">{{ strtoupper(substr($patient->first_name, 0, 1)) }}{{ strtoupper(substr($patient->last_name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $patient->full_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $patient->phone }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-500 py-4 text-center">No patients yet</div>
                        @endif
                    </x-card>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="mt-6">
                <x-card>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('patients.create') }}" class="bg-mint-50 hover:bg-mint-100 p-4 rounded-lg flex items-center">
                            <svg class="h-6 w-6 text-dental-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Add New Patient</span>
                        </a>
                        <a href="{{ route('appointments.create') }}" class="bg-mint-50 hover:bg-mint-100 p-4 rounded-lg flex items-center">
                            <svg class="h-6 w-6 text-dental-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Schedule Appointment</span>
                        </a>
                        <a href="{{ route('procedures.create') }}" class="bg-mint-50 hover:bg-mint-100 p-4 rounded-lg flex items-center">
                            <svg class="h-6 w-6 text-dental-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Add New Procedure</span>
                        </a>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
