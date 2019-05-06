<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Business;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'gender',
        'dob',
        'email',
        'password',
        'phone',
        'soo',
        'lgoo',
        'currentAddress',
        'business_id',
        'branch_id',
        'role'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function branch(){
        return $this->hasOne('App\Branch');
    }
    
    public function sales(){
        return $this->hasMany('App\Sale');
    }
    
    public function expenses(){
        return $this->hasMany('App\Expense');
    }
   
    public function business(){
        return $this->belongsTo('App\Business');
    }
    
    public function stocks(){
        return $this->hasMany('App\Stock');
    }
}
