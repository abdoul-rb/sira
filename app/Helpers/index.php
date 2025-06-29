<?php

// require __DIR__ . '/format.php';


if (!function_exists('current_tenant')) {
    function current_tenant(): ?\App\Models\Company
    {
        return app()->bound('currentTenant') ? app('currentTenant') : null;
    }
}