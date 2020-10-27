@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header container-fluid">
                        <span class="navbar-brand">Candidates</span>
                        <a href="#" role="button" onclick="history.go(-1)"
                           class="btn btn-outline-primary float-right rounded-pill">Return</a>
                    </div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Positions</th>
                                            <th>Candidates with the Highest Votes</th>
                                            <th>Votes</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($positions as $position)

                                            @foreach($position->highestVotes($election) as $candidate)

                                                @if($candidate->votes === $position->highestVotes($election)->max('votes'))
                                                    <tr>
                                                        <td>{{ $position->name }}</td>
                                                        <td>
                                                            {{ $candidate->user->lastname }}
                                                            , {{ $candidate->user->firstname }}
                                                        </td>
                                                        <td>{{ $candidate->votes }}</td>
                                                    </tr>
                                                @elseif($loop->count === $position->vote_limit)
                                                <tr>
                                                    <td>{{ $position->name }}</td>
                                                    <td>
                                                        {{ $candidate->user->lastname }}
                                                        , {{ $candidate->user->firstname }}
                                                    </td>
                                                    <td>{{ $candidate->votes }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="list-group">
                                        @foreach($positions as $position)
                                            <a class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $position->name }}
                                                <div>
                                                    <span
                                                        class="badge badge-primary badge-pill">{{ $position->candidates()->where('election_id', $election->id)->get()->count() }}</span>
                                                </div>
                                            </a>

                                            <div class="list-group show"
                                                 id="collapseExample{{ $position->id }}">
                                                <div class="card card-body">

                                                    @foreach($candidates->where('position_id', $position->id) as $candidate)
                                                        <p class="d-flex justify-content-between align-content-center">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                 aria-valuenow="75" aria-valuemin="0"
                                                                 aria-valuemax="100"
                                                                 style="width: {{ $position->totalVotes($election) === 0 ? 0:($candidate->votes * 100.0) / $position->totalVotes($election) }}%">{{ $candidate->votes }}</div>
                                                        </div>
                                                        <label
                                                            class="d-flex justify-content-between align-content-center">
                                                            {{ $candidate->user->lastname }}
                                                            , {{ $candidate->user->firstname }}
                                                            <span
                                                                class="text-right">Votes: {{ $candidate->votes }}</span>
                                                        </label>

                                                    @endforeach
                                                </div>
                                                <br>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
