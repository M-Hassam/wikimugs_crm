<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'payment_mode', //cash, bank transfer, checque
        'payment_date',
        'payment_time',
        'paid_amount',
        'balance_amount',
        'attachments',
        'notes',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
