<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsCode extends Model
{
    //
    protected $fillable = [
        'phone', 'status', 'code','user_id'
    ];

    public function user()
    {
        $this->belongsTo('App\User');
    }

}
