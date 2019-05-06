<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'business_id',
        'branch_id',
        'type',
        'itemBought',
        'boughtFrom',
        'cost'
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

    public function getTypeAttribute($value){
        return ucfirst($value);
    }
}
