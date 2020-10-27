<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteCount extends Model
{
    protected $table = 'vote_counts';

    protected $fillable = [
        'user_id', 'election_id',
    ];
}
