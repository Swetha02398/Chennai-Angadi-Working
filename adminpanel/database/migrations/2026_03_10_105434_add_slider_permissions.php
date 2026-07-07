<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $module = 'sliders';
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($actions as $action) {
            $slug = $module . '-' . $action;
            $name = ucfirst($action) . ' ' . ucwords(str_replace('-', ' ', $module));

            \App\Models\Permission::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'   => $name,
                    'module' => $module,
                    'action' => $action,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Permission::where('module', 'sliders')->delete();
    }
};
