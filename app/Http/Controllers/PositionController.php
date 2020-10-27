<?php

namespace App\Http\Controllers;

use App\Election;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Election $election
     * @return \Illuminate\Http\Response
     */
    public function index(Election $election)
    {
        $data['election'] = $election;;
//        return response()->view('admin.candidate.pos.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'vote_limit' => 'required',
        ])->validate();


        Position::create($request->all());

        return back()->withSuccess("'$request->name' position successfully added.");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Position $position
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Position $position)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'vote_limit' => 'required',
        ])->validate();

        $position->update($request->all());

        return back()->withSuccess("Position successfully updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Position $position
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Position $position)
    {
        $name = $position->name;
        $position->delete();
        return back()->withSuccess("'$name' position successfully deleted.");
    }
}
