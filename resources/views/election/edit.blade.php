@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header container-fluid">
                        <span class="navbar-brand">Create Election</span>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>{{session('success')}}</strong>
                            </div>
                        @endif
                        <form id="election-create-form" action="{{ route('election.update', $election->id) }}"
                              method="post">
                            @method('PATCH')
                            @csrf

                            <div class="container">
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10">
                                        <input name="title" type="text" class="form-control" id="title"
                                               value="{{ $election->title }}"
                                               autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" type="text" class="form-control" id="description"
                                                  rows="5"
                                                  placeholder="Description"
                                                  style="resize: none;">{{ $election->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="start_at" class="col-sm-2 col-form-label">Start at</label>
                                    <div class="col-sm-10">
                                        <input name="start_at" id="start_at" type="datetime-local" class="form-control"
                                               value="{{ date('Y-m-d\TH:i', strtotime($election->start_at)) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="end_at" class="col-sm-2 col-form-label">End at</label>
                                    <div class="col-sm-10">
                                        <input name="end_at" id="end_at" type="datetime-local" class="form-control"
                                               value="{{ date('Y-m-d\TH:i', strtotime($election->end_at)) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="vote_limit" class="col-sm-2 col-form-label">Vote Limit</label>
                                    <div class="col-sm-4">
                                        <input name="vote_limit" type="number" value="{{ $election->vote_limit }}"
                                               class="form-control">
                                        <small class="text-muted">Number of votes per student</small>
                                    </div>
                                </div>
                                <input type="hidden" name="status" value="close">
                            </div>
                            <div class="container-fluid">
                                <button type="submit" class="btn btn-primary float-right rounded-pill">Save Changes
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
