<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Election;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('election.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $election = Election::create($request->all());

        $today = Carbon::now(new DateTimeZone('Asia/Manila'));
        $start_at = Carbon::createFromDate($request->start_at, new DateTimeZone('Asia/Manila'));
        $end_at = Carbon::createFromDate($request->end_at, new DateTimeZone('Asia/Manila'));

        if ($today->greaterThanOrEqualTo($start_at) && $today->lessThan($end_at)) {
            $election->status = 'open';
        } else {
            $election->status = 'close';
        }
        $election->update();

        return redirect(route('candidates.index', $election->id));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Election $election
     * @return \Illuminate\Http\Response
     */
    public function show(Election $election)
    {
        $data['election'] = $election;
        $data['user'] = Auth::user();

        return response()->view('election.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Election $election
     * @return \Illuminate\Http\Response
     */
    public function edit(Election $election)
    {
        $data['election'] = $election;


        return response()->view('election.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Election $election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Election $election)
    {
        $election->update($request->all());

        if ($request->forced) {
            return redirect(route('election.show', $election->id))->withSuccess('Status successfully changed.');
        }


        $today = Carbon::now(new DateTimeZone('Asia/Manila'));
        $start_at = Carbon::createFromDate($request->start_at, new DateTimeZone('Asia/Manila'));
        $end_at = Carbon::createFromDate($request->end_at, new DateTimeZone('Asia/Manila'));

        if ($today->greaterThanOrEqualTo($start_at) && $today->lessThan($end_at)) {
            $election->status = 'open';
        } else {
            $election->status = 'close';
        }

        $election->update();


        return redirect(route('election.show', $election->id))->withSuccess('Info successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Election $election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Election $election)
    {
        $election->delete();
        Candidate::where('election_id', $election->id)->delete();
        return redirect(route('admin.index'));
    }

//    public function __construct()
//    {
//        $this->middleware('admin');
//    }
}
