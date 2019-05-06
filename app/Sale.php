<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'type',
        'user_id',
        'business_id',
        'branch_id',
        'firstname',
        'lastname',
        'phone',
        'location',
        'productOrService',
        'units',
        'amount',
        'balance',
        'change',
    ];

    public function business()
    {
        return $this->belongsTo('App\Business');
    }
    
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // ACCESSORS
    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }
    public function getProductOrServiceAttribute($value)
    {
        return ucfirst($value);
    }
    public function getFirstnameAttribute($value)
    {
        return ucfirst($value);
    }
    public function getLastnameAttribute($value)
    {
        return ucfirst($value);
    }
    public function getLocationAttribute($value)
    {
        return ucfirst($value);
    }

}
