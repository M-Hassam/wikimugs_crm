<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricePlan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d/m/y',
    ];

    protected $fillable = [
        'domain_id',
        'price_plan_urgency_id',
        'price_plan_level_id',
        'price_plan_type_of_work_id',
        'price'
    ];

    public function type_of_work()
    {
        return $this->belongsTo(PricePlanTypeOfWork::class,'price_plan_type_of_work_id','id');
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class,'domain_id','id');
    }

    public function level()
    {
        return $this->belongsTo(PricePlanLevel::class,'price_plan_level_id','id');
    }

    public function urgency()
    {
        return $this->belongsTo(PricePlanUrgency::class,'price_plan_urgency_id','id');
    }


}
