@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-all-tab" data-toggle="pill"
                                       href="#v-pills-all" role="tab" aria-controls="v-pills-all"
                                       aria-selected="true">All</a>
                                    <a class="nav-link" id="v-pills-open-tab" data-toggle="pill"
                                       href="#v-pills-open" role="tab" aria-controls="v-pills-open"
                                       aria-selected="false">Available</a>
                                </div>
                            </div>

                            <!-- tab content -->
                            <div class="col-9">
                                <!-- alerts -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">x</button>
                                        <strong>{{session('success')}}</strong>
                                    </div>
                            @endif
                            <!-- end alerts -->

                                <!-- tabs -->
                                <div class="tab-content" id="v-pills-tabContent">
                                    <!-- all tab content -->
                                    <div class="tab-pane fade show active" id="v-pills-all" role="tabpanel"
                                         aria-labelledby="v-pills-all-tab">
                                        <div class="container">
                                            <div class="card-columns">
                                                @foreach($elections as $election)
                                                    <div class="card shadow-sm">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <a href="{{ route('election.show', $election->id) }}">
                                                                    {{ $election->title }}
                                                                </a>
                                                            </h5>
                                                            @if($election->status === 'open')
                                                                <h6 class="card-subtitle font-italic text-success text-capitalize">
                                                                    Status: {{ $election->status }}</h6>
                                                            @else
                                                                <h6 class="card-subtitle font-italic text-danger text-capitalize">
                                                                    Status: {{ $election->status }}</h6>
                                                            @endif
                                                            <p class="card-text text-justify text-truncate">{{ $election->description }}</p>
                                                        </div>
                                                        <div class="card-footer">
                                                            @if(count($user->vote_counts->where('election_id', $election->id)) < $election->vote_limit && $election->status === 'open')
                                                                <a href="{{ route('vote.index', $election->id) }}"
                                                                   class="btn btn-outline-primary rounded-pill"
                                                                   role="button">
                                                                    Vote
                                                                </a>
                                                            @elseif(count($user->vote_counts->where('election_id', $election->id)) >= $election->vote_limit  && $election->status === 'open')
                                                                <span class="text-muted font-italic">Used all remaining votes</span>
                                                            @elseif($election->status === 'close')
                                                                <span class="text-muted font-italic">Voting ended</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="v-pills-open" role="tabpanel"
                                         aria-labelledby="v-pills-open-tab">
                                        <div class="container">
                                            <div class="card-columns">
                                                @foreach($elections->where('status', 'open') as $election)
                                                    @if(count($user->vote_counts->where('election_id', $election->id)) < $election->vote_limit)
                                                        <div class="card shadow-sm">
                                                            <div class="card-body">
                                                                <h5 class="card-title">
                                                                    <a href="{{ route('election.show', $election->id) }}">
                                                                        {{ $election->title }}
                                                                    </a>
                                                                </h5>
                                                                @if($election->status === 'open')
                                                                    <h6 class="card-subtitle font-italic text-success text-capitalize">
                                                                        Status: {{ $election->status }}</h6>
                                                                @else
                                                                    <h6 class="card-subtitle font-italic text-danger text-capitalize">
                                                                        Status: {{ $election->status }}</h6>
                                                                @endif
                                                                <p class="card-text text-justify text-truncate">{{ $election->description }}</p>
                                                            </div>
                                                            <div class="card-footer">
                                                                @if(count($user->vote_counts->where('election_id', $election->id)) < $election->vote_limit && $election->status === 'open')
                                                                    <a href="{{ route('vote.index', $election->id) }}"
                                                                       class="btn btn-outline-primary rounded-pill"
                                                                       role="button">
                                                                        Vote
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
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
        </div>
    </div>
@endsection
