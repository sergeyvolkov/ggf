@extends('master')

@section('content')
    <h1>Members</h1>

    <ul>

        @foreach($members as $key => $member)
            <li>{{ $member->name }}</li>
        @endforeach

    </ul>

    <div>
        {!! Form::open(array('method' => 'POST')) !!}
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('facebookId', 'Facebook ID:') !!}
                {!! Form::text('facebookId', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Create', ['class' => 'form-control btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection