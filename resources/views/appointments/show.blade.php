<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointment Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('appointments.edit', $appointment) }}" class="dental-button">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Appointment') }}
                </a>
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dental-button-secondary text-red-600">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Appointment Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="flex items-center">
                                <div class="bg-mint-100 p-3 rounded-full mr-4">
                                    <svg class="h-8 w-8 text-dental-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Appointment #{{ $appointment->id }}</h3>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($appointment->status == 'scheduled') bg-blue-100 text-blue-800
                                        @elseif($appointment->status == 'confirmed') bg-green-100 text-green-800
                                        @elseif($appointment->status == 'completed') bg-purple-100 text-purple-800
                                        @elseif($appointment->status == 'cancelled') bg-red-100 text-red-800
                                        @elseif($appointment->status == 'no_show') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Created on</p>
                            <p class="text-sm font-medium">{{ $appointment->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Appointment Details -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-3 border-b pb-2">Appointment Details</h4>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->start_time->format('h:i A') }} - {{ $appointment->end_time->format('h:i A') }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Procedure</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->procedure->name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->procedure->duration }} minutes</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Cost</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($appointment->procedure->cost, 2) }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Dentist</dt>
                                    <dd class="mt-1 text-sm text-gray-900">Dr. {{ $appointment->dentist->name }}</dd>
                                </div>
                                @if($appointment->notes)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $appointment->notes }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Patient Information -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-3 border-b pb-2">Patient Information</h4>
                            <div class="flex items-center mb-4">
                                <div class="bg-mint-100 h-10 w-10 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-dental-primary font-semibold">{{ strtoupper(substr($appointment->patient->first_name, 0, 1)) }}{{ strtoupper(substr($appointment->patient->last_name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $appointment->patient->full_name }}</p>
                                    <a href="{{ route('patients.show', $appointment->patient) }}" class="text-xs text-dental-primary hover:text-dental-secondary">View Patient Profile</a>
                                </div>
                            </div>
                            
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->patient->phone }}</dd>
                                </div>
                                @if($appointment->patient->email)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->patient->email }}</dd>
                                </div>
                                @endif
                                @if($appointment->patient->date_of_birth)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->patient->date_of_birth->format('M d, Y') }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('appointments.create', ['patient_id' => $appointment->patient->id]) }}" class="bg-mint-50 hover:bg-mint-100 p-4 rounded-lg flex items-center">
                            <svg class="h-6 w-6 text-dental-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Schedule Follow-up</span>
                        </a>
                        
                        <a href="{{ route('appointments.edit', $appointment) }}" class="bg-mint-50 hover:bg-mint-100 p-4 rounded-lg flex items-center">
                            <svg class="h-6 w-6 text-dental-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Update Status</span>
                        </a>
                        
                        <a href="{{ route('patients.show', $appointment->patient) }}" class="bg-mint-50 hover:bg-mint-100 p-4 rounded-lg flex items-center">
                            <svg class="h-6 w-6 text-dental-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">View Patient History</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
