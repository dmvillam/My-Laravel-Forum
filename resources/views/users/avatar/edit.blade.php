@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Actualizar avatar de: {{ $user->nickname }}</div>
                    <div class="panel-body">

                        @include('users.partials.messages')

                        {!! Form::open(['route' => ['users.avatar.update', $user->profile], 'method' => 'PUT', 'files' => true]) !!}
                        <div class="form-group">
                            {!! Form::label('avatar', 'Subir Avatar') !!}
                            {!! Form::file('avatar', null) !!}
                        </div>
                        <button type="submit" class="btn btn-default">
                            <i class="glyphicon glyphicon-pencil"></i> Actualizar
                        </button>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
