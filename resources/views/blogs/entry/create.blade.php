@extends('layouts.app')

@section('title')
    {{ $blog->name }}: Nueva entrada
@endsection

@section('styles')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <ol class="breadcrumb">
                <li><a href="{{ route('blogs.index') }}"><i class="glyphicon glyphicon-book"></i> Blogs</a></li>
                <li><a href="">Blogs de {{ $blog->user->nickname }}</a></li>
                <li><a href="{{ route('blogs.show', [$blog->id]) }}">{{ $blog->name }}</a></li>
                <li class="active">Nueva entrada</li>
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
            <div class="panel-heading"><i class="glyphicon glyphicon-book"></i> Crear nueva entrada</div>
            <div class="panel-body">
                {!! Form::open(['route' => ['blogs.entry.store', $blog], 'method' => 'POST', 'files' => true]) !!}
                {!! Form::hidden('user_id', $blog->user->id) !!}
                {!! Form::hidden('blog_id', $blog->id) !!}
                <div class="form-group">
                    {!! Form::label('title', 'Título:') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un título para la entrada']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('tags', 'Etiquetas:') !!}
                    {!! Form::text('tags', null, ['class' => 'form-control', 'placeholder' => 'Escriba las etiquetas separadas por comas.']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('content', 'Contenido:') !!}
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el contenido de la entrada']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('pic', 'Imagen de la entrada:') !!}
                    {!! Form::file('pic', null) !!}
                </div>
                <button type="submit" class="btn btn-default">
                    <i class="glyphicon glyphicon-plus"></i> Publicar entrada
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
