<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id',
        'comment',
        'created_by',
    ];

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function lead(){
        return $this->belongsTo(Lead::class,'lead_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
