@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col">
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
                console.log($(this).find('input[type=hidden]').val().split(':')[1]);
            });


        });
    </script>
@endsection

