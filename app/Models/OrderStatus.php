<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'status_id',
    ];

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
