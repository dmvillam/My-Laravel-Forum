@extends('admin.layout.admin')

@section('title')
    Panel de Administración - Usuarios
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Usuarios</div>

                @if(Session::has('message'))
                    <p class="alert alert-success">{!! Session::get('message') !!}</p>
                @endif

                <div class="panel-body">

                    @include('admin.users.partials.navigation')

                    <p>
                        <a class="btn btn-info" href="{{ route('admin.users.create') }}" role="button">
                            <i class="glyphicon glyphicon-plus"></i> Nuevo usuario
                        </a>
                    </p>
                    <p>Hay {{ $users->lastPage() }} páginas y {{ $users->total() }} usuarios. Jeje es neta.</p>

                    <table class="table table-striped">
                        <tr>
                            <td><a href="{{ route('admin.users.index') . '?orderby=id' }}">#</a></td>
                            <td><a href="{{ route('admin.users.index') . '?orderby=name' }}">Usuario</a></td>
                            <td><a href="{{ route('admin.users.index') . '?orderby=email' }}">Email</a></td>
                            <td><a href="{{ route('admin.users.index') . '?orderby=type' }}">Tipo</a></td>
                            <td>Acciones</td>
                        </tr>
                        @foreach($users as $user)
                            <tr id="{{ $user->id }}">
                                <td>{{ $user->id }}</td>
                                <td>
                                    {!! $user->profile->ImgAvatar(30,30) !!}
                                    {{ $user->fullname }} (
                                    <a href="{{ route('users.index') . '/' . $user->id }}">
                                        @ {{ $user->nickname }}
                                    </a> )
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ config('options.types')[$user->type] }}</td>
                                <td>
                                    <a title="Editar" href="{!! route('admin.users.edit', $user) !!}"><i class="glyphicon glyphicon-pencil"></i></a>
                                    <a title="Eliminar" href="" class="btn-delete"><i class="glyphicon glyphicon-remove"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $users->appends(Request::all())->render() !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(['route' => ['admin.users.destroy', ':USER_ID'], 'method' => 'DELETE', 'id' => 'form-delete']) !!}
    {!! Form::close() !!}
@endsection


@section('scripts')
<script>
    $(document).ready(function () {
        $('.btn-delete').click(function(e) {
            e.preventDefault();

            if (confirm('¿Seguro que desea eliminar?'))
            {
                var row = $(this).parents('tr');
                var id = row.attr('id');
                var form = $('#form-delete');
                var url = form.attr('action').replace(':USER_ID', id);
                var data = form.serialize();

                $.post(url, data, function (result) {
                    alert(result.message);
                    row.fadeOut();
                }).fail(function () {
                    alert("Ha ocurrido un error. Asegúrate de que aún tienes acceso a internet.");
                });
            }
        });
    });
</script>
@endsection