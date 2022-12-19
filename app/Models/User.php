<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_no',
        'status',
        'name',
        'email',
        'phone',
        'password',
        'created_by',
        'address',
        'identity_verification',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function role()
    // {
    //     $roles = $this->getRoleNames();
    //     $role = $roles->first();
    //     return isset($role) ? $role : ''; 
    // }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    // public function role(){
    //     return $this->belongsTo(Role::class,'role_id','id');
    // }


    public function roles(){
        return $this->belongsToMany(Role::class,'role_users','user_id','role_id');
    }

    /**
     * @var array user $user
     * @var array request data $data
     * 
     * @return Illuminate\Http\Reponse
     */
    public static function saveRole($user,$data){
        if(isset($user) && isset($data) && isset($data['role_ids']) && count($data['role_ids'])){
            foreach($data['role_ids'] as $r_id){
                $r_p = new RoleUser;
                $r_p->role_id = $r_id;
                $r_p->user_id = $user->id;
                $r_p->save();
            }
        }
    }

    /**
     * @var int user  $user
     * @var array request data $data
     * 
     * @return Illuminate\Http\Reponse
     */
    public static function updateRole($user,$data){
        $old_roles = RoleUser::where('user_id',$user->id)->get();
        if(isset($old_roles) && count($old_roles)){
            foreach($old_roles as $role){
                $role->delete();
            }
        }
        User::saveRole($user,$data);
    }
}
