<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_no',
        'domain_id',
        'timezone_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'is_email_notification',
        'is_feedback_notification',
        'is_promotion',
        'is_password',
        'password',
        'status',
        'created_by',
    ];

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function domain(){
        return $this->belongsTo(Domain::class,'domain_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function timezone(){
        return $this->belongsTo(Timezone::class,'domain_id','id');
    }

     /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function orders(){
        return $this->belongsTo(Order::class);
    }
}
