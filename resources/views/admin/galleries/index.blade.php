@extends('admin.layout.admin')

@section('title')
    Panel de Administración - Galerías
@endsection

@section('content')
    <p>
        <button type="button" class="btn btn-primary btn-xs" data-gallery-id="0" data-toggle="modal" data-target="#ModalCreateGallery">
            <i class="glyphicon glyphicon-plus"></i>Crear Galería
        </button>
    </p>

    {{--@include('admin.galleries.partials.tset', ['user' => Auth::user()->nickname])--}}

    <div class="panel panel-default">
        <div class="panel-heading">Administrar galerías</div>
        <div class="panel-body">
            @if (count($galleries) > 0)
                <div class="row">
                    <div class="col-md-1"><p><strong>Id</strong></p></div>
                    <div class="col-md-6"><p><strong>Nombre</strong></p></div>
                    <div class="col-md-1"><p><strong>Orden</strong></p></div>
                    <div class="col-md-4"><p><strong>Opciones</strong></p></div>
                </div>
                @foreach($galleries->where('child_of', '=', 0) as $gallery)
                    @include('admin.galleries.partials.display', ['gallery' => $gallery, 'child_level' => 0])
                @endforeach
            @else
                <i>Sin categorías.</i>
            @endif
        </div>
    </div>

    <!--
      -- Modals
      -->
    {!! Form::open(['route' => 'admin.galleries.store', 'method' => 'POST']) !!}
    <div class="modal fade" id="ModalCreateGallery" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Crear nueva galería:</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('title', 'Nombre') !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la galería', 'id' => 'stitle', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('desc', 'Descripción') !!}
                        {!! Form::text('desc', null, ['class' => 'form-control', 'placeholder' => 'Añadir breve descripción de la galería', 'id' => 'sdesc']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('child_of', 'Sub-galería de:') !!}
                        {!! Form::select('child_of', $c_childs, null, ['class' => 'form-control', 'id' => 'schild_of', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn-create-category" class="btn btn-default">
                        <i class="glyphicon glyphicon-plus"></i> Crear Galería
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::open(['route' => ['admin.galleries.update', ':GALLERY_ID'], 'method' => 'PUT', 'id' => 'form-gallery-update']) !!}
    {!! Form::hidden('edit-route', route('admin.galleries.update', ':GALLERY_ID'), ['id' => 'hidden-update-gallery-route']) !!}
    <div class="modal fade" id="ModalEditGallery" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modificar galería:</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('title', 'Nombre') !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la galería', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('desc', 'Descripción') !!}
                        {!! Form::text('desc', null, ['class' => 'form-control', 'placeholder' => 'Añadir breve descripción de la galería']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('child_of', 'Sub-galería de:') !!}
                        {!! Form::select('child_of', $c_childs, null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn-create-category" class="btn btn-default">
                        <i class="glyphicon glyphicon-plus"></i> Cambiar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::open(['route' => ['admin.galleries.delete', ':GALLERY_ID'], 'method' => 'DELETE', 'id' => 'form-gallery-delete']) !!}
    {!! Form::hidden('route', route('admin.galleries.delete', ':GALLERY_ID'), ['id' => 'hidden-delete-gallery-route']) !!}
    <div class="modal fade" id="ModalDeleteGallery" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar galería</h4>
                </div>
                <div class="modal-body">
                    <p>La galería será eliminada de forma permanente. ¿Deseas continuar?</p>
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

     <!--
      -- Other forms
      -->
    {!! Form::open(['route' => ['admin.galleries.update.up', ':GALLERY_ID'], 'method' => 'PUT', 'id' => 'form-gallery-up-down']) !!}
    {!! Form::hidden('route', route('admin.galleries.update.up', ':GALLERY_ID'), ['id' => 'hidden-gallery-up-route']) !!}
    {!! Form::hidden('route', route('admin.galleries.update.down', ':GALLERY_ID'), ['id' => 'hidden-gallery-down-route']) !!}
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#ModalCreateGallery').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var gallery_id = button.data('gallery-id');
                $('#schild_of').val(button.data('gallery-id'));
            });
            $('#ModalEditGallery').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var gallery_id = button.data('gallery-id');
                var gallery_name = button.data('gallery-title');
                $('#ModalEditGallery').find('.modal-title').text('Modificar galería: ' + gallery_name);
                var action = $('#hidden-update-gallery-route').val().replace(':GALLERY_ID', gallery_id);
                $('#form-gallery-update').attr('action', action);
                $('#title').val(button.data('gallery-title'));
                $('#desc').val(button.data('gallery-desc'));
                $('#child_of').val(button.data('gallery-child-of'));
            });
            $('#ModalDeleteGallery').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var gallery_id = button.data('gallery-id');
                var gallery_name = button.data('gallery-title');
                $('#ModalDeleteGallery').find('.modal-title').text('Eliminar galería: ' + gallery_name);
                var action = $('#hidden-delete-gallery-route').val().replace(':GALLERY_ID', gallery_id);
                $('#form-gallery-delete').attr('action', action);
            });
            $('.up-down-button').click(function () {
                var gallery_id = $(this).attr('data-gallery-id');
                var action_up = $(this).attr('class').indexOf('action-up') !== -1;
                var action_down = $(this).attr('class').indexOf('action-down') !== -1;
                var action;
                if (action_up)
                {
                    action = $('#hidden-gallery-up-route').val().replace(':GALLERY_ID', gallery_id);
                }
                else if (action_down)
                {
                    action = $('#hidden-gallery-down-route').val().replace(':GALLERY_ID', gallery_id);
                }
                else alert("Error tratando de verificar la acción del elemento clickeado, consulte con el programador y digale que es un pendejo porque su pendejada de script no funciona.")
                $('#form-gallery-up-down').attr('action', action);
                $('#form-gallery-up-down').submit();
            });
        });
    </script>
@endsection