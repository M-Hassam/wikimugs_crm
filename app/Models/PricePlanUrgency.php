<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricePlanUrgency extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id',
        'duration',
        'name',
        'amount',
        'percentage',
        'created_by',
    ];

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function domain(){
        return $this->belongsTo(Domain::class,'domain_id','id');
    }

    public static function order_options($search,$domain_id)
    {
        return PricePlanUrgency::select("price_plans.id","price_plan_urgencies.name")
        ->join('price_plans','price_plan_urgencies.id','=','price_plans.id')
        ->where('price_plan_urgencies.name','LIKE',"%$search%")
        ->where('price_plans.domain_id',$domain_id)
        ->groupBy(['price_plans.id','price_plan_urgencies.name'])
        ->get();
    }
}
