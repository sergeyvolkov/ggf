@extends('master')

@section('content')
    <h1>Matches</h1>

    <ul>

        @foreach($matches as $key => $match)
            <li>{{ $match->homeTournamentTeam->team->name }} - {{ $match->awayTournamentTeam->team->name }} ({{ $match->status }})</li>
        @endforeach

    </ul>

    <div>
        {!! Form::open(array('method' => 'POST')) !!}
            <div class="form-group">
                {!! Form::label('tournamentId', 'TournamentId:') !!}
                {!! Form::text('tournamentId', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('homeTournamentTeamId', 'HomeTournamentTeamId:') !!}
                {!! Form::text('homeTournamentTeamId', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('awayTournamentTeamId', 'AwayTournamentTeamId:') !!}
                {!! Form::text('awayTournamentTeamId', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('homeScore', 'HomeScore:') !!}
                {!! Form::text('homeScore', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('awayScore', 'AwayScore:') !!}
                {!! Form::text('awayScore', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('homePenaltyScore', 'HomePenaltyScore:') !!}
                {!! Form::text('homePenaltyScore', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('awayPenaltyScore', 'AwayPenaltyScore:') !!}
                {!! Form::text('awayPenaltyScore', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('resultType', 'ResultType:') !!}
                {!! Form::text('resultType', 'unknown', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Status:') !!}
                {!! Form::text('status', 'not_started', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('gameType', 'GameType:') !!}
                {!! Form::text('gameType', 'group', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('round', 'Round:') !!}
                {!! Form::text('round', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Create', ['class' => 'form-control btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection