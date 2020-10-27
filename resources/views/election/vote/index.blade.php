@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $election->title }} - {{ __('Form') }}</div>
                    {{--                    <form action="{{ route('vote.store', $election->id) }}" method="post"> --}}
                    {{--                    @csrf--}}
                    <div class="card-body">
                        <div class="container">

                            <div class="form">
                                <form action="{{ route('vote.store', $election->id) }}" method="post">
                                    @csrf
                                    @foreach($positions as $position)
                                        <div id="positionCard" class="card border-primary">
                                            <div
                                                class="card-header d-flex justify-content-between align-content-center">
                                                <span class="font-weight-bold">{{ $position->name }}</span>
                                                <span class="text-muted text-right small font-italic">
                                                    Vote per candidate: {{ $position->vote_limit }}
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" id="voteLimit" value="{{ $position->vote_limit }}">
                                                @if($position->vote_limit == 1)
                                                    @foreach($candidates->where('position_id', $position->id) as $candidate)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="{{ strtolower($position->name) }}"
                                                                   id="candidate{{ $candidate->id }}"
                                                                   value="{{ $candidate->id }}">
                                                            <label class="form-check-label"
                                                                   for="candidate{{ $candidate->id }}">
                                                                {{ $candidate->user->lastname }}
                                                                , {{ $candidate->user->firstname }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    @foreach($candidates->where('position_id', $position->id) as $candidate)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="{{ strtolower($position->name) }}"
                                                                   id="candidate{{ $candidate->id }}"
                                                                   value="{{ $candidate->id }}">
                                                            <label class="form-check-label"
                                                                   for="candidate{{ $candidate->id }}">
                                                                {{ $candidate->user->lastname }}
                                                                , {{ $candidate->user->firstname }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <p></p>
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            <button id="submitButton" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#submitButton').click(function () {
                $('form').submit();
            });

            $('form #positionCard input:checkbox').change(function () {
                let $cs = $(this).closest('div .card-body').find(':checkbox:checked');
                if ($cs.length > $cs.closest('div .card-body').find('#voteLimit').val()) {
                    this.checked = false;
                }
            });
        });
    </script>
@endsection

