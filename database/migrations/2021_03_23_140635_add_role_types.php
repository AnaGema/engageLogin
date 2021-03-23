<?php

use App\Models\Roles;
use Illuminate\Database\Migrations\Migration;

class AddRoleTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Roles::create([
                'name' => 'Admin',
                'description' => 'Maximum level of management'
            ]);

            Roles::create([
                'name' => 'Staff',
                'description' => 'Access to some areas of the system'
            ]);
        } catch(Exception $e) {
            echo 'There was an error migrating this values '.$e->getMessage();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Roles::where('name', ['Admin', 'Staff'])->delete();
    }
}
