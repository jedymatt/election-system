<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Election;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function index()
    {
        $data['elections'] = Election::all();

//


        return view('election.result.index', $data);
    }

    public function show(Election $election)
    {
        $data['election'] = $election;
        $data['positions'] = $election->positions();
        $data['candidates'] = $election->candidates()->get()
            ->sortBy(function ($candidate) {
                return $candidate->user->firstname;
            })->sortBy(function ($candidate) {
                return $candidate->user->lastname;
            })->sortBy('position_id');

        return view('election.result.show', $data);
    }
}
