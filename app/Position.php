<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Array_;

class Position extends Model
{
    protected $table = 'positions';

    protected $fillable = [
        'name', 'vote_limit',
    ];

    public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }

    public function totalVotes($election)
    {
        $totalVotes = 0;
        foreach ($this->candidates()->where('election_id', $election->id)->get() as $candidate) {
            $totalVotes += $candidate->votes;
        }
        return $totalVotes;
    }

    public function highestVotes($election)
    {
//        $highestValue = $this->candidates()->where('election_id', $election->id)->first()->votes;
//        $highestCandidate = collect($this->candidates()->where('election_id', $election->id)->get());
//        $arr = Array();
//        $hasEqual = false;
//        foreach ($this->candidates()->where('election_id', $election->id)->get() as $candidate) {
//            if ($candidate->votes > $highestValue) {
//                $highestCandidate = $candidate;
//                $highestValue = $candidate->votes;
//                $hasEqual = false;
//            } elseif ($candidate->votes === $highestValue) {
//                $temp = collect($candidate);
//                $highestCandidate = $temp->collect();
//                $hasEqual = true;
//            }
//        }
        $highestCandidate = $this->candidates()->where('election_id', $election->id)->get()->sortByDesc('votes');
//       dd($highestCandidate->get());
        return $highestCandidate;
    }

}
