<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'address',
        'phone',
        'latitude',
        'longitude',
        'commissionDate',
        'openHour',
        'closeHour'
    ];

    public function sales(){
        return $this->hasMany('App\Sale');
    }

    public function expenses(){
        return $this->hasMany('App\Expense');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function business()
    {
        return $this->belongsTo('App\Business');
    }
    
    public function stocks(){
        return $this->hasMany('App\Stock');
    }


    // ACCESSORS
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    public function getAddressAttribute($value)
    {
        return ucfirst($value);
    }
}
