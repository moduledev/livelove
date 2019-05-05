<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Program extends Model
{
    //
    protected $fillable = [
        'name','description','image','finished','started','term'
    ];

    protected $appends = ['term'];

    public function getTermAttribute()
    {
        $end = Carbon::parse($this->finished);
        $start = Carbon::parse($this->started);
        return $this->attributes['term'] =  $end->diffInDays($start) . ' дней';
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    

}
