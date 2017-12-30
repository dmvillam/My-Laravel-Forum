@extends('layouts.app')

@section('title')
    Búsqueda
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <p><h3><i class="glyphicon glyphicon-cloud"></i> Búsqueda avanzada</h3></p>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Buscar...">
                                    <div class="input-group-btn">
                                        <button id="search-custom-button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Personalizar búsqueda <span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="#" class="search-list" id="search-users">Buscar Usuarios</a></li>
                                            <li><a href="#" class="search-list" id="search-posts">Buscar Temas / Posts</a></li>
                                            <li><a href="#" class="search-list" id="search-blogs">Buscar Blogs</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default">
                                        <i class="glyphicon glyphicon-search"></i> Realizar búsqueda
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default" id="search-posts-form" style="display: none">
                    <div class="panel-body">
                        <p>
                        <div class="row">
                            <div class="col-md-4">
                                <h3><i class="glyphicon glyphicon-search"></i> Buscar Temas/Posts</h3>
                            </div>
                        </div>
                        </p>
                        <hr>
                        <p>
                        <div class="row">
                            <div class="col-md-6">
                                <div>{!! Form::checkbox('location-posts', 'location-posts') !!} {!! Form::label('location-posts', 'Posts (Según ubicación)') !!}</div>
                                <ul style="list-style-type: none">
                                    <li>{!! Form::radio('location', 'location-all', true, ['disabled']) !!} {!! Form::label('location-all', 'En todo el foro') !!}</li>
                                    <li>{!! Form::radio('location', 'location-thread', false, ['disabled']) !!} {!! Form::label('location-thread', 'En un tema') !!} {!! Form::text('location-thread', null, ['placeholder' => 'Id del tema', 'disabled']) !!}</li>
                                    <li>{!! Form::radio('location', 'location-board', false, ['disabled']) !!} {!! Form::label('location-board', 'En un board') !!} {!! Form::text('location-board', null, ['placeholder' => 'Id del board', 'disabled']) !!}</li>
                                    <li>{!! Form::radio('location', 'location-category', false, ['disabled']) !!} {!! Form::label('location-category', 'En una categoría') !!} {!! Form::text('location-category', null, ['placeholder' => 'Id de la categoría', 'disabled']) !!}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div>{!! Form::checkbox('date-posts', 'date-posts') !!} {!! Form::label('date-posts', 'Posts (Según fecha)') !!}</div>
                                <ul style="list-style-type: none">
                                    <li>{!! Form::radio('date', 'date-all', true, ['disabled']) !!} {!! Form::label('date-all', 'Cualquier fecha') !!}</li>
                                    <li>{!! Form::radio('date', 'date-day', false, ['disabled']) !!} {!! Form::label('date-day', 'Último día') !!}</li>
                                    <li>{!! Form::radio('date', 'date-week', false, ['disabled']) !!} {!! Form::label('date-week', 'Última semana') !!}</li>
                                    <li>{!! Form::radio('date', 'date-month', false, ['disabled']) !!} {!! Form::label('date-month', 'Último mes') !!}</li>
                                    <li>{!! Form::radio('date', 'date-year', false, ['disabled']) !!} {!! Form::label('date-year', 'Último año') !!}</li>
                                    <li>{!! Form::radio('date', 'date-custom', false, ['disabled']) !!} {!! Form::label('date-custom-start', 'De:') !!} {!! Form::text('date-custom-start', null, ['placeholder' => 'Inicio', 'disabled']) !!} {!! Form::label('date-custom-end', 'A:') !!} {!! Form::text('date-custom-end', null, ['placeholder' => 'Final', 'disabled']) !!}</li>
                                </ul>
                            </div>
                        </div>
                        </p>
                        <p>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::checkbox('threads', 'threads') !!} {!! Form::label('threads', 'Buscar en títulos de temas') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::checkbox('boards', 'boards') !!} {!! Form::label('boards', 'Buscar en títulos de categorías') !!}
                            </div>
                        </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Search Results -->
        @if ($show != 'nothing')
            <div class="panel panel-default" id="search-result">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <p><h3><i class="glyphicon glyphicon-search"></i> Resultados de la búsqueda</h3></p>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    @if (count($result) > 0)
                        @if ($show == 'users')
                            @include('forum.search_partials.result_users')
                        @elseif ($show == 'posts')
                            @include('forum.search_partials.result_posts')
                        @endif
                    @else
                        La búsqueda no arrojó ningún resultado.
                    @endif

                </div>
            </div>
        @endif

    </div>
@endsection

@section('scripts')
<script src="{{ url('/') }}/js/forum_search_formfunctions.js"></script>
@endsection