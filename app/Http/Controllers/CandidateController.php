<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Election;
use App\Position;
use App\PositionVote;
use App\User;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Election
     * @return \Illuminate\Http\Response
     */
    public function index(Election $election)
    {
        $data['election'] = $election;
        $data['candidates'] = $election->candidates()->get()
            ->sortBy(function ($candidate) {
                return $candidate->user->firstname;
            })->sortBy(function ($candidate) {
                return $candidate->user->lastname;
            })->sortBy('position_id');

        $data['positions'] = $election->candidates()->with('position')->get()
            ->pluck('position')->unique();

        $data['students'] = User::where('role', 'student')->get()
            ->sortBy(function ($user) {
                return $user->firstname;
            })->sortBy(function ($user) {
                return $user->lastname;
            });

        return response()->view('election.candidate.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Election
     * @param \App\Position
     * @return \Illuminate\Http\Response
     */
    public function create(Election $election)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Election $election, Request $request)
    {
        Candidate::create([
            'election_id' => $election->id,
            'user_id' => User::firstWhere('local_id', $request->user_id)->id,
            'position_id' => $request->position_id,
            'votes' => 0,
        ]);

        return back()->withSuccess('Candidate successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param Election $election
     * @param Position $position
     * @param Candidate $candidate
     * @return void
     */
    public function show(Election $election, Position $position, Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Election $election
     * @return \Illuminate\Http\Response
     */
    public function edit(Election $election)
    {
//        $data['election'] = $election;
//        $data['candidates'] = Candidate::where('election_id', $election->id)->get();
//        $data['positions'] = Position::all();
//        return response()->view('admin.candidate.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Candidate $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Election $election
     * @param \App\Candidate $candidate
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Election $election, Candidate $candidate)
    {
        $candidate->delete();

        return back()->withSuccess('Candidate successfully removed.');
    }

}
