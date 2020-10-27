@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">View Election Info</div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h3 class="text-center font-weight-bold">{{ $election->title }}</h3>
                                    <p class="text-center">
                                        <span class="font-weight-bold">Starts at:</span> {{ $election->start_at }}
                                    </p>
                                    <p class="text-center">
                                        <span class="font-weight-bold">Ends at:</span> {{ $election->end_at }}
                                    </p>
                                    <p class="text-center">
                                        <span class="font-weight-bold">Status:</span> {{ strtoupper($election->status)}}
                                    </p>
                                    <div class="card card-body bg-light">
                                        {{ $election->description }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row d-flex justify-content-center">
                            <a href="{{ route('result.show', $election->id) }}" class="btn btn-primary mr-2">
                                View Results</a>
                            @if(\Illuminate\Support\Facades\Auth::user()->role === 'admin')
                                <a href="{{ route('candidates.index', $election->id) }}" class="btn btn-primary mr-2">
                                    Manage Candidates</a>
                                <a href="{{ route('election.edit', $election->id)  }}"
                                   class="btn btn-outline-primary mr-2">Edit</a>
                                <form action="{{ route('election.destroy', $election->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger mr-2">
                                        Delete
                                    </button>
                                </form>
                                <form action="{{ route('election.update', $election->id) }}" method="post">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="forced" value="1">
                                    @if($election->status === 'open')
                                        <input type="hidden" value="close" name="status">
                                        <button type="submit" class="btn btn-outline-danger mr-2">
                                            Force Close
                                        </button>
                                    @else
                                        <input type="hidden" value="open" name="status">
                                        <button type="submit" class="btn btn-outline-danger mr-2">
                                            Force Open
                                        </button>
                                    @endif
                                </form>
                            @else
                                <a href="{{ route('candidates.index', $election->id) }}" class="btn btn-primary mr-2">
                                    View Candidates</a>
                                @if(count($user->vote_counts->where('election_id', $election->id)) < $election->vote_limit && $election->status === 'open')
                                    <a href="{{ route('vote.index', $election->id)  }}"
                                       class="btn btn-primary">Vote</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
