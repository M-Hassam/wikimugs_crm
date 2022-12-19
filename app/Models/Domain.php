<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region_id',
        'tier_id',
        'name',
        'code',
        'url',
        'currency',
        'currency_code',
        'created_by',
    ];

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function region(){
        return $this->belongsTo(Region::class,'region_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function tier(){
        return $this->belongsTo(Tier::class,'tier_id','id');
    }
}
