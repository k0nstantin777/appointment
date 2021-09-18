<?php


namespace App\Services\Admin\Breadcrumbs;

class AdminBreadcrumbs
{
    public function __invoke() : array
    {
        return [
            ADMIN_DASHBOARD_ROUTE => [
                'name' => __("Dashboard"),
            ]
        ];
    }
}
