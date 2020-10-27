@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header container-fluid">
                        <span class="navbar-brand">Candidates</span>
                        <a href="{{ route('election.show', $election->id) }}" role="button"
                           class="btn btn-outline-primary float-right rounded-pill">Go to election</a>
                    </div>

                    <div class="card-body">
                        <div class="container">
                            @if(session('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>{{session('success')}}</strong>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col">
                                    <div class="list-group">
                                        @foreach($positions as $position)
                                            <a href="#collapseExample{{ $position->id }}" role="button"
                                               data-toggle="collapse"
                                               class="list-group-item d-flex justify-content-between align-items-center"
                                               aria-expanded="false"
                                               aria-controls="collapseExample{{$position->id}}">
                                                {{ $position->name }}
                                                <div>
                                                    <span
                                                        class="text-muted font-italic mr-auto small">Vote limit: {{ $position->vote_limit }}</span>
                                                    <span
                                                        class="badge badge-primary badge-pill">{{ $position->candidates()->where('election_id', $election->id)->get()->count() }}</span>
                                                </div>
                                            </a>

                                            <div class="collapse list-group"
                                                 id="collapseExample{{ $position->id }}">

                                                @foreach($candidates->where('position_id', $position->id) as $candidate)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light shadow-sm">
                                                        {{ $candidate->user->lastname }}
                                                        , {{ $candidate->user->firstname }}
                                                        @if(\Illuminate\Support\Facades\Auth::user()->role === 'admin')
                                                            <form
                                                                action="{{ route('candidates.destroy', [$election->id, $candidate->id]) }}"
                                                                method="post">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit"
                                                                        class="btn btn-outline-danger btn-sm rounded-pill">
                                                                    Remove
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </li>
                                                @endforeach
                                                <br>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            @if(\Illuminate\Support\Facades\Auth::user()->role === 'admin')
                                <button class="btn btn-primary rounded-pill shadow-sm" data-toggle="modal"
                                        data-target="#generalCandidateModal">
                                    Add candidate
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="generalCandidateModal" tabindex="-1" role="dialog"
         aria-labelledby="generalCandidateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Candidate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('candidates.store', $election->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="position" class="col-form-label">Position</label>
                            <select id="position" class="custom-select" name="position_id">
                                @foreach(\App\Position::all() as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="search-input" class="col-form-label">Students</label>
                            <div id="result-dropdown" class="dropdown">
                                <input id="search-input" class="form-control"
                                       placeholder="Search using ID or Name" data-toggle="dropdown"
                                       data-target="#result-dropdown">
                                <div id="search-results" class="dropdown-menu container-fluid">
                                    @foreach($students as $student)
                                        <div id="result-item" role="button" class="dropdown-item">
                                            {{ $student->lastname }}, {{ $student->firstname }}
                                            <input type="hidden"
                                                   value="{{ $student->local_id }}:{{ $student->lastname }}, {{ $student->firstname }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <input id="student_id" name="user_id" type="hidden">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal -->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            // show search results
            $("#search-input").on("keyup", function () {
                let value = $(this).val().toLowerCase();
                if (value.length > 1) {
                    $('#result-dropdown').dropdown('show');
                } else {
                    $('#result-dropdown').dropdown('hide');
                }

                $("#result-dropdown #result-item").filter(function () {
                    let arr = $(this).find('input[type=hidden]').val().split(':');

                    function check() {
                        let hasMatch = false;
                        arr.forEach(function (item) {
                            if (item.toLowerCase().indexOf(value) > -1) {
                                return hasMatch = true;
                            }
                        });
                        return hasMatch;
                    }

                    $(this).toggle(check());
                });

                let count = 0;
                $('.dropdown-item:visible').each(function () {
                    count++;
                });

                if (count === 0) {
                    $("#result-dropdown").dropdown('hide');
                }

            });

            $('#search-results #result-item').click(function () {
                let name = $(this).find('input[type=hidden]').val().split(':')[1];
                $('#search-input').val(name);
                $('#result-dropdown #search-results').dropdown('hide');
                let local_id = $(this).find('input[type=hidden]').val().split(':')[0];
                $('#student_id').val(local_id);
            });

            $('#result-dropdown').on('show.bs.dropdown', function () {
                $(this).dropdown('toggle');

            }).on('hidden.bs.dropdown', function () {
                if ($('#search-input').attr('disabled')) {
                    $(this).find('#search-results').hide();
                }
            });

        });
    </script>
@endsection

