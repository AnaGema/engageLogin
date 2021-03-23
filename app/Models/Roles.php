<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Roles extends Model
{
    const ADMIN = 1;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * @param string $name
     * @param string $description
     * @return array
     */
    public function addRole(string $name, string $description)
    {
        return DB::select('call add_role(?,?)', [$name, $description]);
    }

    /**
     * Just for migrate rollback, don't use
     * in case this role has been assigned
     * to any user.
     *
     * @param string $name
     * @return array
     */
    public function removeRole(string $name)
    {
        return DB::select('call remove_role(?)', [$name]);
    }
}
