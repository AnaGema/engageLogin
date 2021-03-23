<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use App\Models\UserRoles;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin User',
            'email'     => 'admin@help.co.uk',
            'is_admin'  => true,
            'password'  => Hash::make('#admin@123')
        ]);

        $userId = User::where('is_admin', true)->first();

        UserRoles::create([
            'user_id'    => $userId->id,
            'role_id'    => Roles::ADMIN,
            'created_at' => Carbon::now(),
        ]);
    }
}
