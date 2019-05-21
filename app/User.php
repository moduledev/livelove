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
        'phone','name','position','biography','image','api_token','facebook','strava','instagram'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    /**
     * Constant - part of path to image folder
     */
    const PHOTOPATH = 'app/public/';


    /** Relation one to many (between user model and SmsCode model)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes()
    {
        return $this->hasMany('App\SmsCode');
    }

    /**Getter return empty string instead of null
     * @return string
     */
    public function getPositionAttribute()
   {
       if($this->attributes['position'] === null){
           return $this->attributes['position'] = '';
       } else {
           return $this->attributes['position'];
       }
   }

    /** Getter return empty string instead of null
     * @return string
     */
    public function getBiographyAttribute()
    {
        if($this->attributes['biography'] === null){
            return $this->attributes['biography'] = '';
        } else {
            return $this->attributes['biography'];
        }
    }

    /**Relation one to many (between user model and program model)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programs()
    {
        return $this->belongsToMany('App\Program','user_program','user_id','program_id');
    }


}
