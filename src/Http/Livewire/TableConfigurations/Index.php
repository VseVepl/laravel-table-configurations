<?php
// packages\vsent\TableConfigurations\src\Http\Livewire\TableConfigurations\Index.php
namespace vsent\TableConfigurations\Http\Livewire\TableConfigurations;

use Livewire\Component;
use Livewire\WithPagination;
use vsent\TableConfigurations\Models\TableConfiguration;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// File: src/Http/Livewire/TableConfigurations/Index.php

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    public string $search = '';
    public string $filterDataType = '';
    public bool $filterNullable = false;

    // Define query string parameters to keep state in URL
    protected array $queryString = [
        'search' => ['except' => ''],
        'filterDataType' => ['except' => ''],
        'filterNullable' => ['except' => false],
    ];

    /**
     * Listen for events.
     * For example, when a record is successfully created or updated.
     *
     * @var array
     */
    protected $listeners = ['tableConfigurationUpdated' => '$refresh', 'tableConfigurationCreated' => '$refresh'];

    /**
     * Reset pagination when search or filters change.
     */
    public function updating($key): void
    {
        if (in_array($key, ['search', 'filterDataType', 'filterNullable'])) {
            $this->resetPage();
        }
    }

    /**
     * Delete a table configuration record.
     *
     * @param TableConfiguration $tableConfiguration The configuration to delete.
     */
    public function delete(TableConfiguration $tableConfiguration): void
    {
        $this->authorize('delete', $tableConfiguration);

        try {
            $tableConfiguration->delete();
            session()->flash('message', 'Table configuration deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting table configuration: ' . $e->getMessage());
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): \Illuminate\View\View
    {
        $this->authorize('viewAny', TableConfiguration::class);

        $query = TableConfiguration::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('table_name', 'like', '%' . $this->search . '%')
                    ->orWhere('column_name', 'like', '%' . $this->search . '%')
                    ->orWhere('column_comments', 'like', '%' . $this->search . '%');
            });
        }

        // Apply data type filter
        if ($this->filterDataType) {
            $query->where('data_type', $this->filterDataType);
        }

        // Apply nullable filter
        if ($this->filterNullable) {
            $query->where('is_nullable', true);
        }

        $tableConfigurations = $query->paginate(config('table-configurations.per_page', 10));

        // Get all unique data types for filter dropdown
        $dataTypes = TableConfiguration::select('data_type')->distinct()->pluck('data_type');

        return view('table-configurations::livewire.table-configurations.index', [
            'tableConfigurations' => $tableConfigurations,
            'dataTypes' => $dataTypes,
        ]);
    }
}
