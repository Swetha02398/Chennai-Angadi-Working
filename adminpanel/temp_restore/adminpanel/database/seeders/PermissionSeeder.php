<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $modules = [
            'dashboard'     => ['view'],
            'categories'    => ['view', 'create', 'edit', 'delete'],
            'products'      => ['view', 'create', 'edit', 'delete'],
            'orders'        => ['view', 'create', 'edit', 'delete'],
            'billing'       => ['view', 'create', 'edit', 'delete'],
            'customers'     => ['view', 'create', 'edit', 'delete'],
            'coupons'       => ['view', 'create', 'edit', 'delete'],
            'offers'        => ['view', 'create', 'edit', 'delete'],
            'shipping'      => ['view', 'create', 'edit', 'delete'],
            'inventory'     => ['view', 'edit'],
            'notifications' => ['view', 'create', 'edit', 'delete'],
            'reports'       => ['view'],
            'sliders'       => ['view', 'create', 'edit', 'delete'],
            'email-history' => ['view', 'delete'],
            'quantity'      => ['view', 'create', 'edit', 'delete'],
            // 'gsthsn'        => ['view', 'create', 'edit', 'delete'],
            // 'hsncode'       => ['view', 'create', 'edit', 'delete'],
            'roles'         => ['view', 'create', 'edit', 'delete'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $slug = $module . '-' . $action;
                $name = ucfirst($action) . ' ' . ucwords(str_replace('-', ' ', $module));

                Permission::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name'   => $name,
                        'module' => $module,
                        'action' => $action,
                    ]
                );
            }
        }

        $this->command->info('✅ ' . Permission::count() . ' permissions seeded successfully!');
    }
}
