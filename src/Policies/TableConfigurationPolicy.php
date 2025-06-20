<?php
// packages\vsent\TableConfigurations\src\Policies\TableConfigurationPolicy.php
namespace vsent\TableConfigurations\Policies;

use App\Models\User; // Assuming your application's User model
use vsent\TableConfigurations\Models\TableConfiguration;
use Illuminate\Auth\Access\Response;

// File: src/Policies/TableConfigurationPolicy.php

class TableConfigurationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Example: Only authenticated users can view the list.
        // You might add roles/permissions here, e.g., $user->hasPermission('view_table_configurations');
        return true; // For demonstration, allow all authenticated users.
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TableConfiguration $tableConfiguration): bool
    {
        // Example: Only authenticated users can view a specific configuration.
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Example: Only authenticated users can create.
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TableConfiguration $tableConfiguration): bool
    {
        // Example: Only authenticated users can update.
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TableConfiguration $tableConfiguration): bool
    {
        // Example: Only authenticated users can delete.
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TableConfiguration $tableConfiguration): bool
    {
        // Typically for soft deletes
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TableConfiguration $tableConfiguration): bool
    {
        // Typically for soft deletes
        return false;
    }
}
