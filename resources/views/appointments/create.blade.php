<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule New Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Patient Selection -->
                            <div>
                                <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                                <select name="patient_id" id="patient_id" class="dental-input" required>
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id || (request()->has('patient_id') && request()->patient_id == $patient->id) ? 'selected' : '' }}>
                                            {{ $patient->full_name }} - {{ $patient->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <div class="mt-2">
                                    <a href="{{ route('patients.create') }}" class="text-sm text-dental-primary hover:text-dental-secondary">
                                        + Add New Patient
                                    </a>
                                </div>
                            </div>

                            <!-- Procedure Selection -->
                            <div>
                                <label for="procedure_id" class="block text-sm font-medium text-gray-700 mb-1">Procedure</label>
                                <select name="procedure_id" id="procedure_id" class="dental-input" required>
                                    <option value="">Select Procedure</option>
                                    @foreach($procedures as $procedure)
                                        <option value="{{ $procedure->id }}" {{ old('procedure_id') == $procedure->id ? 'selected' : '' }}>
                                            {{ $procedure->name }} - ${{ number_format($procedure->cost, 2) }} ({{ $procedure->duration }} min)
                                        </option>
                                    @endforeach
                                </select>
                                @error('procedure_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dentist Selection -->
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Dentist</label>
                                <select name="user_id" id="user_id" class="dental-input" required>
                                    <option value="">Select Dentist</option>
                                    @foreach($dentists as $dentist)
                                        <option value="{{ $dentist->id }}" {{ old('user_id') == $dentist->id ? 'selected' : '' }}>
                                            Dr. {{ $dentist->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Appointment Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="dental-input" required>
                                    @foreach($statuses as $key => $value)
                                        <option value="{{ $key }}" {{ old('status', 'scheduled') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Appointment Date -->
                            <div>
                                <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-1">Appointment Date</label>
                                <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', date('Y-m-d')) }}" class="dental-input" required min="{{ date('Y-m-d') }}">
                                @error('appointment_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Appointment Time -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', '09:00') }}" class="dental-input" required>
                                @error('start_time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="dental-input">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('appointments.index') }}" class="dental-button-secondary mr-2">Cancel</a>
                            <button type="submit" class="dental-button">Schedule Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
