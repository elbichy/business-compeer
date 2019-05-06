<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'cac',
        'nature',
        'website',
        'email',
        'phone',
        'logo'
    ];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function branch(){
        return $this->hasMany('App\Branch');
    }

    public function expenses(){
        return $this->hasMany('App\Expense');
    }
    
    public function sales(){
        return $this->hasMany('App\Sale');
    }
    
    public function stocks(){
        return $this->hasMany('App\Stock');
    }
}
