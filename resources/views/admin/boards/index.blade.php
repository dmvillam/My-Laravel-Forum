@extends('admin.layout.admin')

@section('title')
    Panel de Administración - Categorías y Boards
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(Session::has('message'))
            <p class="alert alert-success">{!! Session::get('message') !!}</p>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">Administrar Foros</div>
            <div class="panel-body">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCreateCategory">
                    Nueva Categoría
                </button>
            </div>
        </div>

        @if (count($categories) > 0)
            @foreach($categories as $category)
                <div class="panel panel-default category-division" id="{{ $category->id }}">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-11">
                                {{ $category->name }} <a href="#" data-cname="{{ $category->name }}" data-toggle="modal" data-target="#ModalEditCategory"><i class="glyphicon glyphicon-pencil"></i></a>
                            </div>
                            <div class="col-md-1">
                                <div class="pull-right">
                                    <a href="#" data-toggle="modal" data-target="#ModalDeleteCategory">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if (count($category->boards) > 0)
                            <div class="row">
                                <div class="col-md-1"><p><strong>Id</strong></p></div>
                                <div class="col-md-4"><p><strong>Nombre</strong></p></div>
                                <div class="col-md-2"><p><strong>Logo</strong></p></div>
                                <div class="col-md-1"><p><strong>Orden</strong></p></div>
                                <div class="col-md-3"><p><strong>Opciones</strong></p></div>
                            </div>
                            @foreach($category->boards()->orderBy('order', 'ASC')->get() as $board)
                                <div class="row board-division" id="{{ $board->id }}">
                                    <div class="col-md-1"><p>{{ $board->id }}</p></div>
                                    <div class="col-md-4"><p><a href="" title="{{ $board->desc }}">{{ $board->name }}</a></p></div>
                                    <div class="col-md-2">
                                        <p>
                                            <a href="" data-bname="{{ $board->name }}" data-toggle="modal" data-target="#ModalLogoBoard">
                                                {{ $board->logo=="" ? 'default.png' : $board->logo }}
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-md-1"><p>{{ $board->order }}</p></div>
                                    <div class="col-md-3">
                                        <p>
                                            <a href="{{ route('admin.boards.edit', $board) }}">
                                                <i class="glyphicon glyphicon-pencil"></i> Modificar
                                            </a>
                                            <a href="#" data-bname="{{ $board->name }}" data-toggle="modal" data-target="#ModalDeleteBoard">
                                                <i class="glyphicon glyphicon-trash"></i> Eliminar
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-12"><i>Sin boards.</i></div>
                            </div>
                        @endif
                            <div class="panel pull-right">
                                <p>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalCreateBoard">
                                        <i class="glyphicon glyphicon-plus"></i> Agregar board
                                    </button>
                                </p>
                            </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="panel panel-default">
                <div class="panel-heading">Foro vacío</div>
                <div class="panel-body">
                    <i>Sin categorías.</i>
                </div>
            </div>
        @endif
    </div>
</div>

{!! Form::open(['route' => 'admin.categories.store', 'method' => 'POST']) !!}
<div class="modal fade" id="ModalCreateCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear nueva categoría:</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la categoría', 'required' => 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('order', 'Orden:') !!}
                    {!! Form::select('order', $c_orders, "last", ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn-create-category" class="btn btn-default">
                    <i class="glyphicon glyphicon-plus"></i> Nueva Categoría
                </button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

{!! Form::open(['route' => 'admin.boards.store', 'method' => 'POST']) !!}
<div class="modal fade" id="ModalCreateBoard" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear nuevo board:</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del board', 'required' => 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('desc', 'Descripción') !!}
                    {!! Form::text('desc', null, ['class' => 'form-control', 'placeholder' => 'Breve descripción']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('category_id', 'Ubicar en categoría:') !!}
                    {!! Form::select('category_id', $c_names, null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn-create-board" class="btn btn-default">
                    <i class="glyphicon glyphicon-pencil"></i> Nuevo board
                </button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

{!! Form::hidden('route', route('admin.categories.delete', ':CATEGORY_ID'), ['id' => 'hidden-delete-category-route']) !!}
{!! Form::open(['route' => ['admin.categories.delete', ':CATEGORY_ID'], 'method' => 'DELETE', 'id' => 'form-category-delete']) !!}
<div class="modal fade" id="ModalDeleteCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Categoría</h4>
            </div>
            <div class="modal-body">
                <p><strong>Advertencia:</strong> si eliminas la categoría también serán eliminados todos los boards y posts contenidos en ésta.</p>
                <p>¿Estás seguro que deseas continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn-delete-category" class="btn btn-danger">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

{!! Form::hidden('route', route('admin.boards.delete', ':BOARD_ID'), ['id' => 'hidden-delete-board-route']) !!}
{!! Form::open(['route' => ['admin.boards.delete', ':BOARD_ID'], 'method' => 'DELETE', 'id' => 'form-board-delete']) !!}
<div class="modal fade" id="ModalDeleteBoard" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Board</h4>
            </div>
            <div class="modal-body">
                <p><strong>Advertencia:</strong> si eliminas la board también serán eliminados todos los posts contenidos en ésta.</p>
                <p>¿Estás seguro que deseas continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn-delete-board" class="btn btn-danger">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

{!! Form::hidden('route', route('admin.categories.update', ':CATEGORY_ID'), ['id' => 'hidden-update-category-route']) !!}
{!! Form::open(['route' => ['admin.categories.update', ':CATEGORY_ID'], 'method' => 'PUT', 'id' => 'form-category-update']) !!}
<div class="modal fade" id="ModalEditCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar categoría:</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la categoría', 'required' => 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('order', 'Orden:') !!}
                    {!! Form::select('order', $c_orders_edit, "default", ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn-edit-category" class="btn btn-default">
                    <i class="glyphicon glyphicon-plus"></i> Modificar
                </button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}


{!! Form::hidden('route', route('admin.boards.logo', ':BOARD_ID'), ['id' => 'hidden-logo-board-route']) !!}
{!! Form::open(['route' => ['admin.boards.logo', ':BOARD_ID'], 'method' => 'PUT', 'id' => 'form-logo-board-update', 'files' => true]) !!}
<div class="modal fade" id="ModalLogoBoard" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cambiar el logo del board</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('logo', 'Logo para el board') !!}
                    {!! Form::file('logo', null) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn-board-logo" class="btn btn-default">
                    <i class="glyphicon glyphicon-pencil"></i> Cambiar
                </button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#ModalCreateBoard').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $('#ModalCreateBoard').find('input[name="name"]').val('');
            $('#ModalCreateBoard').find('input[name="desc"]').val('');
            var cat_id = button.parents('.category-division').attr('id');
            $('#ModalCreateBoard').find('#category_id').val(cat_id);
        });

        $('#ModalDeleteCategory').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var cat_id = button.parents('.category-division').attr('id');
            var cat_name = button.data('cname');
            $('#ModalDeleteCategory').find('.modal-title').text('Eliminar Categoría: ' + cat_name);
            var action = $('#hidden-delete-category-route').val().replace(':CATEGORY_ID', cat_id);
            $('#form-category-delete').attr('action', action);
        });

        $('#ModalDeleteBoard').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var board_id = button.parents('.board-division').attr('id');
            var board_name = button.data('bname');
            $('#ModalDeleteBoard').find('.modal-title').text('Eliminar Board: ' + board_name);
            var action = $('#hidden-delete-board-route').val().replace(':BOARD_ID', board_id);
            $('#form-board-delete').attr('action', action);
        });

        $('#ModalEditCategory').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var cat_id = button.parents('.category-division').attr('id');
            var cat_name = button.data('cname');
            $('#ModalEditCategory').find('.modal-title').text('Editar Categoría: ' + cat_name);
            var action = $('#hidden-update-category-route').val().replace(':CATEGORY_ID', cat_id);
            $('#form-category-update').attr('action', action);
            $('#form-category-update').find('input#name').val(cat_name);
        });

        $('#ModalLogoBoard').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var board_id = button.parents('.board-division').attr('id');
            var board_name = button.data('bname');
            $('#ModalLogoBoard').find('.modal-title').text('Cambiar el logo del board: ' + board_name);
            var action = $('#hidden-logo-board-route').val().replace(':BOARD_ID', board_id);
            $('#form-logo-board-update').attr('action', action);
        });
    });
</script>
@endsection