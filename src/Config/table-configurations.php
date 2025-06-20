<?php

// File: src/Config/table-configurations.php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Configurations Prefix
    |--------------------------------------------------------------------------
    |
    | This value specifies a prefix for the package's routes. This is useful
    | if you want to group all table configuration routes under a specific
    | URI segment, e.g., 'admin/table-configurations'.
    |
    */
    'route_prefix' => 'table-configurations', // Example: 'admin/table-configurations'

    /*
    |--------------------------------------------------------------------------
    | Table Configurations Middleware
    |--------------------------------------------------------------------------
    |
    | This array specifies the middleware that should be applied to the
    | package's routes. You can add authentication, authorization, etc.
    |
    */
    'middleware' => ['web', 'auth'], // Example: ['web', 'auth', 'can:manage-configurations']

    /*
    |--------------------------------------------------------------------------
    | Pagination Per Page
    |--------------------------------------------------------------------------
    |
    | This value determines the number of records displayed per page
    | when listing table configurations.
    |
    */
    'per_page' => 10,
];
