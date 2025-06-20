<?php
// packages\vsent\TableConfigurations\src\Http\Controllers\TableConfigurationsController.php
namespace vsent\TableConfigurations\Http\Controllers;

use App\Http\Controllers\Controller; // Assuming default Laravel Controller
use Illuminate\Http\Request;
use vsent\TableConfigurations\Models\TableConfiguration;
use vsent\TableConfigurations\Http\Requests\TableConfigurationRequest;
use vsent\TableConfigurations\Http\Resources\TableConfigurationResource;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

// File: src/Http/Controllers/TableConfigurationsController.php

class TableConfigurationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * This method primarily serves as an entry point to the Livewire index page.
     */
    public function index(): View
    {
        // Livewire component handles the actual listing logic
        return view('table-configurations::table-configurations.index');
    }

    /**
     * Show the form for creating a new resource.
     * This method primarily serves as an entry point to the Livewire create page.
     */
    public function create(): View
    {
        // Livewire component handles the actual form logic
        return view('table-configurations::table-configurations.create');
    }

    /**
     * Store a newly created resource in storage.
     * This could be used for an API endpoint if not handled by Livewire forms.
     */
    public function store(TableConfigurationRequest $request): JsonResponse
    {
        $this->authorize('create', TableConfiguration::class);

        $tableConfiguration = TableConfiguration::create($request->validated());

        return response()->json([
            'message' => 'Table configuration created successfully.',
            'data' => new TableConfigurationResource($tableConfiguration)
        ], 201);
    }

    /**
     * Display the specified resource.
     * This method primarily serves as an entry point to the Livewire show page.
     */
    public function show(TableConfiguration $tableConfiguration): View
    {
        $this->authorize('view', $tableConfiguration);

        // Livewire component handles displaying the details
        return view('table-configurations::table-configurations.show', compact('tableConfiguration'));
    }

    /**
     * Show the form for editing the specified resource.
     * This method primarily serves as an entry point to the Livewire edit page.
     */
    public function edit(TableConfiguration $tableConfiguration): View
    {
        $this->authorize('update', $tableConfiguration);

        // Livewire component handles the actual form logic
        return view('table-configurations::table-configurations.edit', compact('tableConfiguration'));
    }

    /**
     * Update the specified resource in storage.
     * This could be used for an API endpoint if not handled by Livewire forms.
     */
    public function update(TableConfigurationRequest $request, TableConfiguration $tableConfiguration): JsonResponse
    {
        $this->authorize('update', $tableConfiguration);

        $tableConfiguration->update($request->validated());

        return response()->json([
            'message' => 'Table configuration updated successfully.',
            'data' => new TableConfigurationResource($tableConfiguration)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * This could be used for an API endpoint if not handled by Livewire actions.
     */
    public function destroy(TableConfiguration $tableConfiguration): JsonResponse
    {
        $this->authorize('delete', $tableConfiguration);

        $tableConfiguration->delete();

        return response()->json(['message' => 'Table configuration deleted successfully.']);
    }
}
