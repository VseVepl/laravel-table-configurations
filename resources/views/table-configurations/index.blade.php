{{-- File: src/Resources/views/table-configurations/index.blade.php --}}

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">Table Configurations</h1>

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

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Search by table, column, or comment..."
                class="form-input px-4 py-2 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
            <select
                wire:model.live="filterDataType"
                class="form-select px-4 py-2 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-48">
                <option value="">Filter by Data Type</option>
                @foreach($dataTypes as $dataType)
                <option value="{{ $dataType }}">{{ $dataType }}</option>
                @endforeach
            </select>
            <label class="flex items-center space-x-2">
                <input
                    wire:model.live="filterNullable"
                    type="checkbox"
                    class="form-checkbox h-5 w-5 text-blue-600 rounded dark:bg-gray-700 dark:border-gray-600">
                <span class="text-gray-700 dark:text-gray-300">Show Nullable Only</span>
            </label>
        </div>
        @can('create', \vsent\TableConfigurations\Models\TableConfiguration::class)
        <a href="{{ route('table-configurations.create') }}" wire:navigate
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out w-full sm:w-auto text-center">
            Create New Configuration
        </a>
        @endcan
    </div>

    @if ($tableConfigurations->isEmpty())
    <p class="text-center text-gray-600 dark:text-gray-400">No table configurations found matching your criteria.</p>
    @else
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Table Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Column Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Data Type
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nullable
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($tableConfigurations as $config)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                        {{ $config->table_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $config->column_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $config->data_type }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $config->is_nullable ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ $config->is_nullable ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('table-configurations.show', $config) }}" wire:navigate
                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600 mr-3">View</a>
                        @can('update', $config)
                        <a href="{{ route('table-configurations.edit', $config) }}" wire:navigate
                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3">Edit</a>
                        @endcan
                        @can('delete', $config)
                        <button
                            wire:click="delete({{ $config->id }})"
                            wire:confirm="Are you sure you want to delete this configuration?"
                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">
                            Delete
                        </button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $tableConfigurations->links() }}
    </div>
    @endif
</div>