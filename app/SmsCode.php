<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsCode extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'status', 'code','user_id'
    ];


    /**Relation one to many (between user model and SmsCode model)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
       return $this->belongsTo('App\User');
    }

}
