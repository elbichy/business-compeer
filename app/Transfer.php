<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sales_id',
        'refNumber',
        'recievers_firstname',
        'recievers_lastname',
        'bankName',
        'accountType',
        'accountNumber',
        'recievers_phone',
        'amount',
        'amountInWords',
        'status',
    ];

    public function sale()
    {
        return $this->belongsTo('App\Sale');
    }
    
    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
}
