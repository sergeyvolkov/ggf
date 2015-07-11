@extends('master')

@section('content')
    <h1>Teams</h1>

    <ul>

        @foreach($teams as $key => $team)
            <li>{{ $team->name }}</li>
        @endforeach

    </ul>

    <div>
        {!! Form::open(array('method' => 'POST')) !!}
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('logoPath', 'Logo:') !!}
                {!! Form::text('logoPath', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Create', ['class' => 'form-control btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection