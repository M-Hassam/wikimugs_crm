<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    use HasFactory;

    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'log_type_id',
        'domain_id',
        'user_id',
        'general_id',
        'slug',
        'description',
        'created_by',
    ];

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function log_type(){
        return $this->belongsTo(LogType::class,'log_type_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function domain(){
        return $this->belongsTo(Domain::class,'domain_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
