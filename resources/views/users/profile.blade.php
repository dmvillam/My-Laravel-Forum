@extends('layouts.app')

@section('title')
    Perfil de {{ $user->nickname }}
@endsection

@section('style')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('forum.board.index') }}"><i class="glyphicon glyphicon-home"></i> Índice de Foros</a></li>
                <li class="active">Perfil de {{ $user->nickname }}</li>
            </ol>

            @if(Session::has('message'))
                <p class="alert alert-success">{!! Session::get('message') !!}</p>
            @endif

            <div class="row">
                <div class="col-md-9">
                    @include('users.partials.profile.part2')
                </div>
                <div class="col-md-3">
                    @include('users.partials.profile.part1')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ url('/') . '/js/profile_comments.js' }}"></script>
@endsection
