<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'is_active',
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // public function permissions(){
    //     return $this->hasMany(RolePermission::class);
    // }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsToMany
    */
    public function permissions(){
        return $this->belongsToMany(Permission::class,'role_permissions', 'role_id', 'permission_id');
    }

    /**
     * @var int role id $role_id
     * @var array request data $data
     * 
     * @return Illuminate\Http\Reponse
     */
    public static function savePermission($role_id,$data){
        if(isset($role_id) && isset($data) && isset($data['permissions']) && count($data['permissions'])){
            foreach($data['permissions'] as $p_id){
                $r_p = new RolePermission;
                $r_p->role_id = $role_id;
                $r_p->permission_id = $p_id;
                $r_p->save();
            }
        }
    }

    /**
     * @var int role id $role_id
     * @var array request data $data
     * 
     * @return Illuminate\Http\Reponse
     */
    public static function updatePermission($role_id,$data){
        $old_permissions = RolePermission::where('role_id',$role_id)->get();
        if(isset($old_permissions) && count($old_permissions)){
            foreach($old_permissions as $p){
                $p->delete();
            }
        }
        Role::savePermission($role_id,$data);
    }
}
