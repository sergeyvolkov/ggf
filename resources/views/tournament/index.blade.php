@extends('master')

@section('content')
    <h1>Tournaments</h1>

    <ul>

        @foreach($tournaments as $key => $tournament)
            <li>{{ $tournament->name }}</li>
        @endforeach

    </ul>

    <div>
        {!! Form::open(array('method' => 'POST')) !!}
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Create', ['class' => 'form-control btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection