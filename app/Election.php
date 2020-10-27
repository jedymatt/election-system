<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $table = 'elections';

    protected $fillable = [
        'title', 'description', 'start_at', 'end_at', 'vote_limit', 'status',
    ];

    public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }

    public function user_votes()
    {
        return $this->hasManyThrough('App\UserVote', 'App\Candidate');
    }

    public function positions()
    {
        return $this->candidates()->with('position')->get()
            ->pluck('position')->unique();
    }

}
