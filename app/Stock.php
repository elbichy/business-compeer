<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'type',
        'user_id',
        'business_id',
        'branch_id',
        'item',
        'unitPrice',
        'bulkUnit',
        'bulkUnitPrice',
        'availableUnits' 
    ];

    public function users(){
        return $this->belongsTo('App\User');
    }
    public function business(){
        return $this->belongsTo('App\Business');
    }
    public function branch(){
        return $this->belongsTo('App\Branch');
    }
}
