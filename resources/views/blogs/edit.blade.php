@extends('layouts.app')

@section('title')
    Crear nuevo blog
@endsection

@section('styles')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <ol class="breadcrumb">
                <li><a href="{{ route('blogs.index') }}"><i class="glyphicon glyphicon-book"></i> Blogs</a></li>
                <li class="active">Editar blog</li>
            </ol>
        </div>
    </div>

    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p>{{ trans('validation.errors') }}</p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading"><i class="glyphicon glyphicon-pencil"></i> Editar Blog: {{ $blog->name }}</div>
            <div class="panel-body">
                {!! Form::model($blog, ['route' => ['blogs.update', $blog], 'method' => 'PUT']) !!}
                {!! Form::hidden('user_id', $blog->user->id) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Nombre del Blog') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un nombre para su Blog']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('desc', 'Descripción') !!}
                    {!! Form::textarea('desc', null, ['class' => 'form-control', 'placeholder' => 'Agrege una breve descripción']) !!}
                </div>
                <button type="submit" class="btn btn-default">
                    <i class="glyphicon glyphicon-ok"></i> Guardar cambios
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
