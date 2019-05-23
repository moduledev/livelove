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
        'title','description','image','finished','started','duration','location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $appends = ['duration','participants','nextDate','comments'];


    /**
     * Getter, add quantity of program members to response
     * @return int
     */
    public function getParticipantsAttribute()
    {
        return $this->users()->count();
    }

    /**
     * Getter, add quantity of comments to response
     * @return int
     */
    public function getCommentsAttribute()
    {
        return $this->users()->count();
    }

    
    /**
     * Getter, add next_date of event to response
     * @return int
     */
    public function getNextDateAttribute()
    {
        $starterd = Carbon::parse($this->started)->addWeek(1);
        return (string) $starterd;
    }

    /**Getter returns term of program in milliseconds
     * @return int
     */
    public function getDurationAttribute()
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

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

}
