<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Status;

class Order extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $order_statuses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_new',
        'domain_id',
        'lead_id',
        'customer_id',
        'status_id',
        'instructions',
        'coupon_id',
        'topic',
        'order_no',
        'no_of_pages',
        'line_spacing',
        'reference',
        'font_style',
        'price_plan_type_of_work_id',
        'price_plan_level_id',
        'price_plan_urgency_id',
        'price_plan_no_of_page_id',
        'price_plan_indentation_id',
        'price_plan_subject_id',
        'price_plan_style_id',
        'price_plan_language_id',
        'total_amount',
        'manual_discount_amount',
        'discount_amount',
        'old_discount_amount',
        'addons_amount',
        'service_amount',
        'grand_total_amount',
        'actual_total_amount',
        'created_by',
        'writer_id',
        'writer_deadline',
        'customer_sent_date',
        'is_reassigned',
        'writer_submit_date'
    ];

    protected $appends = [
        'attachments',
        'order_statuses'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getAttachmentsAttribute(){
        return $this->getMedia('attachments');
    }

    public function getOrderStatusesAttribute(){
        return $this->order_statuses();
    }

    public function order_statuses(){
        return Status::all()->ToArray();
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getGenOrderIdAttribute($value)
    {
        return "{$this->domain->code}-{$this->id}";
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function domain(){
        return $this->belongsTo(Domain::class,'domain_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function coupon(){
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function lead(){
        return $this->belongsTo(Lead::class,'lead_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function status(){
        return $this->belongsTo(Status::class,'status_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function subjects(){
        return $this->belongsTo(PricePlanSubject::class,'price_plan_subject_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function style(){
        return $this->belongsTo(PricePlanStyle::class,'price_plan_style_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function level(){
        return $this->belongsTo(PricePlanLevel::class,'price_plan_level_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function type_of_work(){
        return $this->belongsTo(PricePlanTypeOfWork::class,'price_plan_type_of_work_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function urgency(){
        return $this->belongsTo(PricePlanUrgency::class,'price_plan_urgency_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function no_of_pages(){
        return $this->belongsTo(PricePlanNoOfPage::class,'price_plan_no_of_page_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function writer(){
        return $this->belongsTo(User::class,'writer_id','id');
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function files(){
        return $this->hasMany(OrderFile::class);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function final_order_files(){
        return $this->hasMany(OrderFile::class)->where('is_attach',1);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function client_guidlines(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',1);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function writing_deptartments(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',2);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function writer_deliveries(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',3);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function revision_writing_depts(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',4);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function revision_deliveries(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',5);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function revision_clients(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',6);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function final_deliveries(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',7);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function revision_for_writer(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',4)->orWhere('file_status_id',6);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function order_guidelines(){
        return $this->hasMany(OrderFile::class)->where('file_status_id',1)->orWhere('file_status_id',2);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function comments(){
        return $this->hasMany(OrderComment::class);
    }

    /**
    * @return /Illuminate/Database/Eloquent/Relations/belongsTo
    */
    public function addons(){
        return $this->hasMany(OrderAddon::class);
    }
}
