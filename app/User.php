<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone','name','position','biography','image'
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

    public $with = ['programs'];

    public function codes()
    {
        return $this->hasMany('App\SmsCode');
    }

   public function getPositionAttribute()
   {
       if($this->attributes['position'] === null){
           return $this->attributes['position'] = '';
       } else {
           return $this->attributes['position'];
       }
   }

    public function getBiographyAttribute()
    {
        if($this->attributes['biography'] === null){
            return $this->attributes['biography'] = '';
        } else {
            return $this->attributes['biography'];
        }
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program','user_program','user_id','program_id');
    }

    public function user()
    {

    }
}
