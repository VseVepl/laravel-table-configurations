{{-- File: src/Resources/views/table-configurations/edit.blade.php --}}

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">Edit Table Configuration</h1>

    @if (session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p>{{ session('message') }}</p>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <form wire:submit.prevent="updateTableConfiguration">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="table_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Table Name <span class="text-red-500">*</span></label>
                    <input type="text" id="table_name" wire:model="table_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('table_name') border-red-500 @enderror">
                    @error('table_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="column_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Column Name <span class="text-red-500">*</span></label>
                    <input type="text" id="column_name" wire:model="column_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('column_name') border-red-500 @enderror">
                    @error('column_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="data_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Type <span class="text-red-500">*</span></label>
                    <select id="data_type" wire:model.live="data_type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('data_type') border-red-500 @enderror">
                        <option value="">Select a data type</option>
                        @foreach($allDataTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('data_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                @if (in_array($data_type, ['VARCHAR', 'CHAR', 'DECIMAL', 'ENUM', 'SET']))
                <div>
                    <label for="length_or_values" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Length / Values (e.g., 255, 'active','inactive')
                    </label>
                    <input type="text" id="length_or_values" wire:model="length_or_values"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('length_or_values') border-red-500 @enderror">
                    @error('length_or_values') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                @else
                <input type="hidden" wire:model="length_or_values">
                @endif

                <div>
                    <label for="default_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Value</label>
                    <input type="text" id="default_value" wire:model="default_value"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('default_value') border-red-500 @enderror">
                    @error('default_value') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="character_collation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Character Collation</label>
                    <input type="text" id="character_collation" wire:model="character_collation"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('character_collation') border-red-500 @enderror">
                    @error('character_collation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="column_attributes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Column Attributes (e.g., UNSIGNED)</label>
                    <input type="text" id="column_attributes" wire:model="column_attributes"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('column_attributes') border-red-500 @enderror">
                    @error('column_attributes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="index_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Index Type (e.g., PRIMARY, UNIQUE, INDEX)</label>
                    <input type="text" id="index_type" wire:model="index_type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('index_type') border-red-500 @enderror">
                    @error('index_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_nullable" wire:model="is_nullable"
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_nullable" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Is Nullable</label>
                    @error('is_nullable') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_auto_increment" wire:model="is_auto_increment"
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_auto_increment" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Is Auto Increment</label>
                    @error('is_auto_increment') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="column_comments" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Column Comments</label>
                <textarea id="column_comments" wire:model="column_comments" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('column_comments') border-red-500 @enderror"></textarea>
                @error('column_comments') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('table-configurations.index') }}" wire:navigate
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Configuration
                </button>
            </div>
        </form>
    </div>
</div>