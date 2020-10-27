<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVote extends Model
{
    protected $table = 'user_votes';

    protected $fillable = [
        'candidate_id', 'user_id',
    ];

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
}
