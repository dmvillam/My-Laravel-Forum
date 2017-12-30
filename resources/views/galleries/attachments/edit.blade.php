@extends('layouts.app')

@section('title')
    Editar detalles de {{ $attachment->original_name }}
@endsection

@section('styles')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <ol class="breadcrumb">
                <li><a href="{{ route('galleries.index') }}"><i class="glyphicon glyphicon-picture"></i> Galerías</a></li>
                <li><a href="{{ route('galleries.show', $attachment->gallery) }}">{{ $attachment->gallery->title }}</a></li>
                <li><a href="{{ route('gallery.attachments.index', $attachment) }}">{{ $attachment->original_name }}</a></li>
                <li class="active">Editando detalles de {{ $attachment->original_name }}</li>
            </ol>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editando detalles de {{ $attachment->original_name }}</div>
                    <div class="panel-body">
                        {!! Form::model($attachment->details, ['route' => ['gallery.attachments.update', $attachment], 'method' => 'PUT']) !!}
                        {!! Form::hidden('user_id', $attachment->user->id) !!}
                        <div class="form-group">
                            {!! Form::label('original_name', 'Título') !!}
                            {!! Form::text('original_name', $attachment->original_name, ['class' => 'form-control', 'placeholder' => 'Título de la imagen']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('desc', 'Comentarios sobre la imagen') !!}
                            {!! Form::textarea('desc', null, ['class' => 'form-control', 'placeholder' => 'Descripción del adjunto']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', 'Etiquetas:') !!}
                            {!! Form::text('tags', null, ['class' => 'form-control', 'placeholder' => 'Ingrese las etiquetas separadas por comas']) !!}
                        </div>
                        <hr>
                        <div class="form-group">
                            {!! Form::checkbox('featured', 'true', $attachment->details->featured) !!}
                            {!! Form::label('featured', 'Imagen destacada.') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('pinned', 'true', $attachment->details->pinned) !!}
                            {!! Form::label('pinned', 'Fijar imagen.') !!}
                        </div><div class="form-group">
                            {!! Form::checkbox('locked', 'true', $attachment->details->locked) !!}
                            {!! Form::label('locked', 'Desactivar comentarios.') !!}
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-default">
                            <i class="glyphicon glyphicon-pencil"></i> Cambiar
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection