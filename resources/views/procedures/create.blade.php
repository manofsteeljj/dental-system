<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Procedure') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('procedures.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Procedure Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Procedure Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="dental-input" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cost -->
                            <div>
                                <label for="cost" class="block text-sm font-medium text-gray-700">Cost ($)</label>
                                <input type="number" name="cost" id="cost" value="{{ old('cost') }}" class="dental-input" required min="0" step="0.01">
                                @error('cost')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration') }}" class="dental-input" required min="1">
                                @error('duration')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="dental-input">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('procedures.index') }}" class="dental-button-secondary mr-2">Cancel</a>
                            <button type="submit" class="dental-button">Save Procedure</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
