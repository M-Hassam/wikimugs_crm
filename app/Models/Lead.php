<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{
    LeadComment
};

class Lead extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id',
        'lead_status_id',
        'is_new',
        'name',
        'email',
        'phone',
        'comments',
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
    public function status(){
        return $this->belongsTo(LeadStatus::class,'lead_status_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/BelongsTo
    */
    public function comments(){
        return $this->hasMany(LeadComment::class);
    }

    public static function saveComment($lead_id,$domain_id,$comment){
        $lead_comm = new LeadComment;
        $lead_comm->lead_id = $lead_id;
        $lead_comm->comment = $comment;
        $lead_comm->created_by =auth()->user()->id;
        $lead_comm->save();

        $data = [
            'log_type_id'=>1 ,
            'domain_id'=>$domain_id ?? null,
            'user_id'=>auth()->user()->id ?? null,
            'general_id'=>$lead_id ?? null,
            'slug'=>'lead-comments-added',
            'description'=>auth()->user()->name.' has added lead comments',
            'created_at'=>date('y-m-d h:i:s')
        ];

        LogModel::insert($data);
        return true;
    }
}
