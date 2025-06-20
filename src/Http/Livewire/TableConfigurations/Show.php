<?php
// packages\vsent\TableConfigurations\src\Http\Livewire\TableConfigurations\Show.php
namespace vsent\TableConfigurations\Http\Livewire\TableConfigurations;

use Livewire\Component;
use vsent\TableConfigurations\Models\TableConfiguration;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// File: src/Http/Livewire/TableConfigurations/Show.php

class Show extends Component
{
    use AuthorizesRequests;

    public TableConfiguration $tableConfiguration;

    /**
     * Mount the component with an existing TableConfiguration.
     *
     * @param TableConfiguration $tableConfiguration The TableConfiguration model instance.
     * @return void
     */
    public function mount(TableConfiguration $tableConfiguration): void
    {
        $this->authorize('view', $tableConfiguration);
        $this->tableConfiguration = $tableConfiguration;
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
            $this->redirect(route('table-configurations.index'), navigate: true);
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
        return view('table-configurations::livewire.table-configurations.show');
    }
}
