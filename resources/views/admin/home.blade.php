@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill"
                                       href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                       aria-selected="true">Home</a>
                                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                                       href="#v-pills-position" role="tab" aria-controls="v-pills-position"
                                       aria-selected="false">Manage Positions</a>
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
                                    <!-- home tab content -->
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                         aria-labelledby="v-pills-home-tab">
                                        <!-- button create -->
                                        <div class="row">
                                            <div class="container-fluid">
                                                <a href="{{ route('election.create') }}" role="button"
                                                   class="btn btn-primary float-right"> Create Election</a>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="container">
                                                <div class="card-columns">
                                                    @foreach($elections as $election)
                                                        <div class="card shadow-sm">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $election->title }}</h5>
                                                                @if($election->status === 'open')
                                                                    <h6 class="card-subtitle font-italic text-success text-capitalize">
                                                                        Status: {{ $election->status }}</h6>
                                                                @else
                                                                    <h6 class="card-subtitle font-italic text-danger text-capitalize">
                                                                        Status: {{ $election->status }}</h6>
                                                                @endif
                                                                <p class="card-text text-truncate">{{ $election->description }}</p>
                                                            </div>
                                                            <div class="card-footer">
                                                                <a href="{{ route('election.show', $election->id) }}"
                                                                   class="btn btn-primary rounded-pill" role="button">
                                                                    View
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <!-- manage position // status: done -->
                                    <div class="tab-pane fade" id="v-pills-position" role="tabpanel"
                                         aria-labelledby="v-pills-position-tab">
                                        <ul id="list-position" class="list-group">
                                            <label>Available Positions</label>
                                            @foreach($positions as $position)
                                                <li id="position-item"
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $position->name }}

                                                    <form id="remove-position-form"
                                                          action="{{ route('position.destroy', $position->id) }}"
                                                          method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <span
                                                            class="text-muted font-italic mr-2">Vote limit: {{ $position->vote_limit }}</span>
                                                        <button type="button" id="edit-position-button"
                                                                class="btn btn-outline-primary btn-sm rounded-pill"
                                                                data-toggle="modal"
                                                                data-target="#edit-position-modal-{{ $position->id }}">
                                                            Edit
                                                        </button>
                                                        <button type="submit"
                                                                class="btn btn-outline-danger btn-sm rounded-pill">
                                                            Remove
                                                        </button>
                                                    </form>

                                                </li>
                                                <!-- Modal -->
                                                <div class="modal fade" id="edit-position-modal-{{ $position->id }}"
                                                     tabindex="-1"
                                                     role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit
                                                                    position</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="edit-position-form" method="post"
                                                                  action="{{ route('position.update', $position->id) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <label for="position-name" class="col-form-label">Enter
                                                                        new position name</label>
                                                                    <input id="position-name" name="name"
                                                                           type="text" class="form-control"
                                                                           value="{{ $position->name }}">
                                                                    <label for="position-vote-limit"
                                                                           class="col-form-label">Enter
                                                                        new vote limit</label>
                                                                    <input id="position-vote-limit" name="vote_limit"
                                                                           type="number" class="form-control"
                                                                           value="{{ $position->vote_limit }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end modal -->
                                            @endforeach
                                        </ul>
                                        <p>
                                        <p class="container d-flex justify-content-center align-content-center">
                                            <a id="addNewPositionAnchor" class="btn btn-primary rounded-pill"
                                               data-toggle="collapse" href="#addPositionCollapse" role="button"
                                               aria-expanded="false" aria-controls="collapseExample">
                                                Add New Position
                                            </a>
                                        </p>
                                        <!-- input position form -->
                                        <div class="collapse bg-light" id="addPositionCollapse">
                                            <form id="add-position-form" action="{{ route('position.store') }}"
                                                  method="post">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <label for="name" class="col-form-label col-3">Position</label>
                                                        <div class="col">
                                                            <input type="text" id="nameNewPosition" name="name" class="form-control"
                                                                   placeholder="Add new position">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="vote_limit" class="col-form-label col-3">Vote Limit</label>
                                                        <div class="col">
                                                            <input type="number" id="vote_limit" name="vote_limit" value="1"
                                                                   class="form-control"
                                                                   placeholder="Add Vote Limit">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-content-center justify-content-center">
                                                        <button type="submit"
                                                                class="btn btn-primary btn-sm rounded-pill">
                                                            Submit Position
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end input position form -->
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

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            // start of manage positions

            $('.modal.fade').on('shown.bs.modal', function () {
                let inputPosition = $(this).find("input[id=position-name]");
                let value = inputPosition.val();
                inputPosition.focus().val('').val(value);

                $(this).parent().submit(function () {
                    $(this).find('button[type=submit]').attr('disabled', true);
                });
            });

            $('#remove-position-form').submit(function () {
                $(this).find('button[type=submit]').attr('disabled', true);
            });

            $('#add-position-form').submit(function () {
                $(this).find('button[type=submit]').attr('disabled', true);
            });

            // end of manage positions

            $('#addPositionCollapse').on('shown.bs.collapse', function () {
                $('input[type=text][id=nameNewPosition]').focus();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $('input[type=text][id=nameNewPosition]').offset().top
                }, 1000);
            });

        });
    </script>
@endsection
