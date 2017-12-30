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
                <li class="active">Nuevo blog</li>
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
            <div class="panel-heading"><i class="glyphicon glyphicon-book"></i> Crear nuevo blog</div>
            <div class="panel-body">
                {!! Form::open(['route' => 'blogs.store', 'method' => 'POST', 'files' => true]) !!}
                {!! Form::hidden('user_id', Auth::user()->id) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Nombre del Blog') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un nombre para su Blog']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('desc', 'Descripción') !!}
                    {!! Form::textarea('desc', null, ['class' => 'form-control', 'placeholder' => 'Agrege una breve descripción']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('banner', 'Banner para tu blog') !!}
                    {!! Form::file('banner', null) !!}
                </div>
                <button type="submit" class="btn btn-default">
                    <i class="glyphicon glyphicon-plus"></i> Crear Blog
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
