<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Program class
 *
*/
class Program extends Model
{
    /**
     * Constant - part of path to image folder
     */
    const PHOTOPATH = 'app/public/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','description','image','finished','started','term'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $appends = ['term','membersCount'];


    /**
     * Getter, add quantity of program members to response
     * @return int
     */
    public function getMembersCountAttribute()
    {
        return $this->users()->count();
    }

    /**Getter returns term of program in milliseconds
     * @return int
     */
    public function getTermAttribute()
    {
        $end = Carbon::parse($this->finished);
        $start = Carbon::parse($this->started);
        return $this->attributes['term'] =  $end->diffInSeconds($start);
    }

    /**Relation one to many (between user model and program model)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User','user_program','program_id','user_id');
    }
    

}
