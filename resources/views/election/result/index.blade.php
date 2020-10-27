@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-all-tab" data-toggle="pill"
                                       href="#v-pills-all" role="tab" aria-controls="v-pills-all"
                                       aria-selected="true">Ongoing</a>
                                    <a class="nav-link" id="v-pills-open-tab" data-toggle="pill"
                                       href="#v-pills-open" role="tab" aria-controls="v-pills-open"
                                       aria-selected="false">Ended</a>
                                </div>
                            </div>

                            <!-- tab content -->
                            <div class="col-9">
                                <!-- tabs -->
                                <div class="tab-content" id="v-pills-tabContent">
                                    <!-- all tab content -->
                                    <div class="tab-pane fade show active" id="v-pills-all" role="tabpanel"
                                         aria-labelledby="v-pills-all-tab">
                                        <div class="container">
                                            <div class="card-columns">
                                                @foreach($elections->where('status', 'open') as $election)
                                                    <div class="card shadow-sm">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <a href="{{ route('result.show', $election->id) }}">
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
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="v-pills-open" role="tabpanel"
                                         aria-labelledby="v-pills-open-tab">
                                        <div class="container">
                                            <div class="card-columns">
                                                @foreach($elections->where('status', 'close') as $election)
                                                    <div class="card shadow-sm">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <a href="{{ route('result.show', $election->id) }}">
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
        </div>
    </div>
@endsection
