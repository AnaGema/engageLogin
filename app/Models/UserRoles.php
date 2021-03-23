<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $fillable = [
        'user_id',
        'role_id',
        'enabled'
    ];

    public function role()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }

    /**
     * Adds the changes to the user role table, disables
     * first and enables or creates new registers.
     *
     * @param array $data
     */
    public static function addChanges(array $data)
    {
        // Archive current roles assigned to the user
        UserRoles::where('user_id', $data['user'])
            ->update([
                'enabled' => false
            ]);

        // Re-enable or insert new roles for the user
        foreach($data['roles'] as $role) {
            UserRoles::updateOrCreate(
                ['user_id' => $data['user'], 'role_id' => $role],
                ['enabled' => 1]
            );
        }
    }
}
