<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
    * Check whether user is authorised or not.
    *
    * @param  User current auth $user
    * @param  Page id $page_id
    *  
    * @return Boolean user is authorised ot not true or false 
    */
    public function permission($user,$page_id)
    {
        $roles = Role::whereIn('id',$user->roles->pluck('id')->toArray())->get();
        if(isset($roles) && count($roles)){
            foreach ($roles as $key => $role) {
                if(isset($role->permissions) && count($role->permissions)){
                    if(in_array($page_id,$role->permissions->pluck('id')->toArray())){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
