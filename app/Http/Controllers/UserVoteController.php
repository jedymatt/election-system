<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Election;
use App\Position;
use App\UserVote;
use App\VoteCount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Election $election
     * @return Response | RedirectResponse
     */
    public function index(Election $election)
    {
        if ($election->status === 'close' ||
            count(Auth::user()->vote_counts->where('election_id', $election->id)) >= $election->vote_limit) {
            return redirect(route('election.show', $election->id));
        }
        $data['user'] = Auth::user();
        $data['election'] = $election;
        $data['positions'] = $election->candidates()->with('position')->get()
            ->pluck('position')->unique();
        $data['candidates'] = $election->candidates()->get()
            ->sortBy(function ($candidate) {
                return $candidate->user->firstname;
            })->sortBy(function ($candidate) {
                return $candidate->user->lastname;
            })->sortBy('position_id');

        return response()->view('election.vote.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request, Election $election)
    {
        if ($election->status === 'close') {
            return redirect(route('election.show', $election->id));
        }
        foreach ($request->except(['_token']) as $candidate_id) {
            $vote = UserVote::create([
                'candidate_id' => $candidate_id,
                'user_id' => Auth::user()->id,
            ]);

            $candidate = Candidate::findOrFail($candidate_id);
            $num_votes = $candidate->votes;
            $candidate->votes = ++$num_votes;
            $candidate->update();

        }

        VoteCount::create([
            'user_id' => Auth::user()->id,
            'election_id' => $election->id,
        ]);

        return redirect(route('election.show', $election->id));
    }

    /**
     * Display the specified resource.
     *
     * @param UserVote $vote
     * @return Response
     */
    public function show(UserVote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UserVote $vote
     * @return Response
     */
    public function edit(UserVote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UserVote $vote
     * @return Response
     */
    public function update(Request $request, UserVote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserVote $vote
     * @return Response
     */
    public function destroy(UserVote $vote)
    {
        //
    }
}
