<?php

use App\Models\Roles;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            (new Roles)->addRole('InviteUsers', 'This user level grants the option to invite new staff members.');
            (new Roles)->addRole('ArchiveUsers', 'This user level grants the option to archive non active staff members.');
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
        (new Roles)->removeRole(Roles::where('name', 'InviteUsers')->first()->id);
        (new Roles)->removeRole(Roles::where('name', 'ArchiveUsers')->first()->id);
    }
}
