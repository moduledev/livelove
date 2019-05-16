<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Program extends Model
{
    const PHOTOPATH = 'app/public/';


    protected $fillable = [
        'name','description','image','finished','started','term'
    ];

    protected $appends = ['term','membersCount'];

    public function getMembersCountAttribute()
    {
        return $this->users()->count();
    }

    // public function getMembersAttribute()
    // {
    //     return $this->users()->get();
    // }
    
    public function getTermAttribute()
    {
        $end = Carbon::parse($this->finished);
        $start = Carbon::parse($this->started);
        return $this->attributes['term'] =  $end->diffInMilliseconds($start);
    }

    public function users()
    {
        return $this->belongsToMany('App\User','user_program','program_id','user_id');
    }
    

}
