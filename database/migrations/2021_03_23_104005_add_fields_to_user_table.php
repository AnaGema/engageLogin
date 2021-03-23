<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender', 1)->nullable()->after('email');
            $table->string('address')->nullable()->after('gender');
            $table->string('postcode')->nullable()->after('address');
            $table->string('county')->nullable()->after('postcode');
            $table->string('phone')->nullable()->after('county');
            $table->string('job_title')->nullable()->after('phone');
            $table->string('about_me')->nullable()->after('job_title');
            $table->tinyInteger('is_admin')->default(0)->after('about_me');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('address');
            $table->dropColumn('postcode');
            $table->dropColumn('county');
            $table->dropColumn('phone');
            $table->dropColumn('job_title');
            $table->dropColumn('about_me');
            $table->dropColumn('is_admin');
        });
    }
}
