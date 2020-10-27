@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header container-fluid">
                        <span class="navbar-brand">Add Candidate</span>
                    </div>

                    <div class="card-body">
                        <div class="container">
                            <form action="{{ route('candidate.store', $election->id) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <select class="form-control" id="position" name="name">
                                        @foreach($positions as $position)
                                            @if(!\App\Candidate::where('election_id', $election->id)->where('position_id', $position->id)->exists())
                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
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
                            </form>


                            {{--                            <div class="form-group row table-hover">--}}





                            {{--                                <table id="candidates-table" class="table">--}}
                            {{--                                    <thead>--}}
                            {{--                                    <tr>--}}
                            {{--                                        <th scope="col">Positions</th>--}}
                            {{--                                        <th scope="col">Candidates</th>--}}
                            {{--                                        <th scope="col"></th>--}}
                            {{--                                    </tr>--}}
                            {{--                                    </thead>--}}
                            {{--                                    <tbody>--}}
                            {{--                                    <tr>--}}
                            {{--                                        <td>--}}
                            {{--                                            <select id="position" class="custom-select">--}}
                            {{--                                                @foreach($positions as $position)--}}
                            {{--                                                    <option value="{{ $position->id }}">--}}
                            {{--                                                        {{ $position->name }}--}}
                            {{--                                                    </option>--}}
                            {{--                                                @endforeach--}}
                            {{--                                            </select>--}}
                            {{--                                        </td>--}}
                            {{--                                        <td>--}}
{{--                                                                                                    <div id="result-dropdown" class="dropdown">--}}
{{--                                                                                                        <input id="search-input" class="form-control"--}}
{{--                                                                                                               placeholder="Search using ID or Name" data-toggle="dropdown"--}}
{{--                                                                                                               data-target="#result-dropdown">--}}
{{--                                                                                                        <div id="search-results" class="dropdown-menu container-fluid">--}}
{{--                                                                                                            @foreach($students as $student)--}}
{{--                                                                                                                <div id="result-item" role="button" class="dropdown-item">--}}
{{--                                                                                                                    {{ $student->lastname }}, {{ $student->firstname }}--}}
{{--                                                                                                                    <input type="hidden"--}}
{{--                                                                                                                           value="{{ $student->local_id }}:{{ $student->lastname }}, {{ $student->firstname }}">--}}
{{--                                                                                                                </div>--}}
{{--                                                                                                            @endforeach--}}
{{--                                                                                                        </div>--}}
{{--                                                                                                    </div>--}}
                            {{--                                            <br>--}}
                            {{--                                            <div class="form-group">--}}
                            {{--                                                <button class="btn btn-success form-control">--}}
                            {{--                                                    Add candidate--}}
                            {{--                                                </button>--}}
                            {{--                                            </div>--}}
                            {{--                                        </td>--}}
                            {{--                                        <td>--}}
                            {{--                                            <a id="remove-button" role="button"--}}
                            {{--                                               class="btn btn-outline-danger btn-sm float-right">--}}
                            {{--                                                Remove--}}
                            {{--                                            </a>--}}
                            {{--                                        </td>--}}
                            {{--                                    </tr>--}}
                            {{--                                    </tbody>--}}
                            {{--                                </table>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {


            // show search results
            $("#search-input").on("keyup", function () {
                let value = $(this).val().toLowerCase();
                if (value.length > 0) {
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
                console.log(name);
                $('#search-input').val(name).attr('disabled', true);
            });

            $('#result-dropdown').on('show.bs.dropdown', function () {
                $(this).dropdown('toggle');

            });

            $('#result-dropdown').on('hidden.bs.dropdown', function () {
                if ($('#search-input').attr('disabled')) {
                    $(this).find('#search-results').hide();
                }
            });

        });
    </script>
@endsection
