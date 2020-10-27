<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'election_id', 'user_id', 'position_id', 'votes',
    ];

    public function election()
    {
        return $this->belongsTo('App\Election');
    }

    public function position()
    {
        return $this->belongsTo('App\Position');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function user_votes()
    {
        return $this->hasMany('App\UserVote');
    }

}
