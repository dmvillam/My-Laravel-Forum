@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $board->category->name }} > {{ $board->name }}</div>
                    <div class="panel-body">

                        @include('admin.users.partials.messages')

                        {!! Form::model($board, ['route' => ['admin.boards.update', $board], 'method' => 'PUT']) !!}
                        <div class="form-horizontal">
                            {!! Form::label('order', 'Orden:') !!}
                            {!! Form::select('order', $b_names, "default", ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Nombre') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del board']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('desc', 'Descripción') !!}
                            {!! Form::text('desc', null, ['class' => 'form-control', 'placeholder' => 'Breve descripción']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('category_id', 'Ubicar en categoría:') !!}
                            {!! Form::select('category_id', $c_names, "default", ['class' => 'form-control']) !!}
                        </div>
                        <button type="submit" class="btn btn-default">
                            <i class="glyphicon glyphicon-pencil"></i> Editar board
                        </button>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
