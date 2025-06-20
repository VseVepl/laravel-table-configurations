{{-- File: src/Resources/views/table-configurations/show.blade.php --}}

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">Table Configuration Details</h1>

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

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
            <div>
                <p class="font-semibold">ID:</p>
                <p>{{ $tableConfiguration->id }}</p>
            </div>
            <div>
                <p class="font-semibold">Table Name:</p>
                <p>{{ $tableConfiguration->table_name }}</p>
            </div>
            <div>
                <p class="font-semibold">Column Name:</p>
                <p>{{ $tableConfiguration->column_name }}</p>
            </div>
            <div>
                <p class="font-semibold">Data Type:</p>
                <p>{{ $tableConfiguration->data_type }}</p>
            </div>
            <div>
                <p class="font-semibold">Length/Values:</p>
                <p>{{ $tableConfiguration->length_or_values ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="font-semibold">Default Value:</p>
                <p>{{ $tableConfiguration->default_value ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="font-semibold">Character Collation:</p>
                <p>{{ $tableConfiguration->character_collation ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="font-semibold">Column Attributes:</p>
                <p>{{ $tableConfiguration->column_attributes ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="font-semibold">Is Nullable:</p>
                <p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tableConfiguration->is_nullable ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                        {{ $tableConfiguration->is_nullable ? 'Yes' : 'No' }}
                    </span>
                </p>
            </div>
            <div>
                <p class="font-semibold">Index Type:</p>
                <p>{{ $tableConfiguration->index_type ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="font-semibold">Is Auto Increment:</p>
                <p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tableConfiguration->is_auto_increment ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $tableConfiguration->is_auto_increment ? 'Yes' : 'No' }}
                    </span>
                </p>
            </div>
            <div class="col-span-1 md:col-span-2">
                <p class="font-semibold">Column Comments:</p>
                <p>{{ $tableConfiguration->column_comments ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="font-semibold">Created At:</p>
                <p>{{ $tableConfiguration->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
            <div>
                <p class="font-semibold">Updated At:</p>
                <p>{{ $tableConfiguration->updated_at->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <a href="{{ route('table-configurations.index') }}" wire:navigate
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
            Back to List
        </a>
        @can('update', $tableConfiguration)
        <a href="{{ route('table-configurations.edit', $tableConfiguration) }}" wire:navigate
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Edit
        </a>
        @endcan
        @can('delete', $tableConfiguration)
        <button
            wire:click="delete({{ $tableConfiguration->id }})"
            wire:confirm="Are you sure you want to delete this configuration?"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Delete
        </button>
        @endcan
    </div>
</div>