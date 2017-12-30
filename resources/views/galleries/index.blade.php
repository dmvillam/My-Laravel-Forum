@extends('layouts.app')

@section('title')
    {{ $gallery==null ? 'Galleries' : $gallery->title }}
@endsection

@section('styles')
    <style>
        .galleryBlock {
            position: relative;
            height: 115px;
            background-color: #333;
            background-size: cover;
            background-position: 50%;
            background-repeat: no-repeat;
            margin: 8px 0;
        }
        .galleryLabel {
            position: absolute;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            color: white;
            width: 100%;
            padding: 2px 8px;
        }
        .imagePreviewLoadingTable {
            background: white;
            height: 130px;
            display: table;
            width: 100%;
            background-size: cover;
            background-position: 50%;
            background-repeat: no-repeat;
        }
        .imagePreviewLoadingTableCell {
            vertical-align: middle;
            display: table-cell;
            color: darkgray;
        }
        .loadingBarBorder {
            border: 1px solid darkgray;
            border-radius: 9px;
            width: 80%;
            height: 12px;
            margin: auto;
        }
        .loadingBar {
            background: black;
            border: 1px solid black;
            border-radius: 8px;
            height: 10px;
        }
        .imageThumb .hoverElem {
            display: none;
        }
        .imageThumb:hover .hoverElem {
            display: block;
        }
        .imagePreviewDelete {
            position: relative;
            height: 130px;
        }
        .imagePreviewDeleteButton {
            position: absolute;
            bottom: 0;
            right: 0;
            margin: 6px;
            border-radius: 4px;
            background: darkseagreen;
            padding: 2px 8px;
        }
        .modal {
            background: rgba(30,30,30,0.4);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .imgModal {
            background: rgba(20,20,20,0.95);
            position: fixed;
            top: 40px;
            bottom: 40px;
            left: 40px;
            right: 40px;
            box-shadow: 0px 5px 55px rgba(0,0,0,0.4);
        }
        #attachmentShow {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            max-width: 100%;
            max-height: 100%;
            margin: auto;
        }
        .imgModal button {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            font-size: 38px;
            line-height: 18px;
            opacity: 1;
        }
        .imgModal a {
            position: absolute;
            font-size: 12px;
            line-height: 28px;
            padding: 0 15px;
            background: rgba(0,0,0,0.5);
            opacity: 0.6;
            color: #fff;
            transition: 0.1s all linear;
            border-radius: 3px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .imgModal a:hover {
            background: #000;
            opacity: 1;
            text-decoration: none;
            cursor: pointer;
        }
        .tags {
            background: #23374a;
            padding: 0px 8px;
            color: white;
            margin-left: 10px;
            font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
            font-size: 0.8em;
            border-radius: 0 2px  2px 0;
        }
        .tags::before {
            content: "";
            border-top: 8px solid transparent;
            border-right: 8px solid #23374a;
            border-bottom: 9px solid transparent;
            width: 0;
            height: 0;
            position: absolute;
            margin-top: 3px;
            margin-bottom: 0;
            margin-left: -16px;
            margin-right: 0;
        }
        .tags:hover {
            background: #121d27;
            color: darkgray;
            text-decoration: none;
        }
        .tags:hover:before {
            border-right: 8px solid #121d27;
            font-size: 2.5em;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <ol class="breadcrumb">
                <li><a href="{{ route('galleries.index') }}"><i class="glyphicon glyphicon-picture"></i> Galerías</a></li>
                <li class="active">{{ $gallery==null ? 'Índice' : $gallery->title }}</li>
            </ol>
        </div>
    </div>

    <div class="row" style="margin: 10px 20px; position: relative;">
        @if ($request_tags != null)
            <h2>Buscando:</h2>
            <p>{{ $request_tags }}</p>
        @elseif ($gallery == null)
            <h1>Galerías</h1>
        @else
            <h1>{{ $gallery->title }}</h1>
            <p>{{ $gallery->desc }}</p>
        @endif
        @if ( ! Auth::guest())
            <a class="btn btn-default pull-right" role="button" data-toggle="modal" data-target="#ModalCreateAttachment">
                <i class="glyphicon glyphicon-plus"></i> Añadir imágenes
            </a>
        @endif
    </div>

    @if (count($galleries) > 0 && $request_tags == null)
        <div class="row" style="margin:5px">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Galerías</div>
                    <div class="panel-body">
                        <div class="row">
                            @foreach($galleries as $sgallery)
                                <div class="col-md-3">
                                    <a href="{{ route('galleries.show', $sgallery) }}">
                                        <div class="galleryBlock" style="background-image: url('{{ count($sgallery->attachments) > 0 ? url('/') . '/attachments/' . $sgallery->attachments->last()->file_name : '' }}');">
                                            <div class="galleryLabel">
                                                <div><b>{{ $sgallery->title }}</b></div>
                                                <div style="font-size: 0.85em; display: inline;">
                                                    <ul style="list-style-type: none; display: inline">
                                                        <li class="pull-right" style="margin: 0 5px;" data-toggle="tooltip" data-placement="top" title="{{ count(\App\Gallery::where('child_of', '=', $sgallery->id)->get()) }} subgalería{{ count(\App\Gallery::where('child_of', '=', $sgallery->id)->get())==1?'':'s' }}"><i class="glyphicon glyphicon-th-large"></i> {{ count(\App\Gallery::where('child_of', '=', $sgallery->id)->get()) }}</li>
                                                        <li class="pull-right" style="margin: 0 5px;" data-toggle="tooltip" data-placement="top" title="{{ count($sgallery->comments) }} comentario{{ count($sgallery->comments)==1?'':'s' }}"><i class="glyphicon glyphicon-comment"></i> {{ count($sgallery->comments) }}</li>
                                                        <li class="pull-right" style="margin: 0 5px;" data-toggle="tooltip" data-placement="top" title="{{ count($sgallery->attachments) }} imágen{{ count($sgallery->attachments)==1?'':'es' }}"><i class="glyphicon glyphicon-camera"></i> {{ count($sgallery->attachments) }}</li>
                                                        <li class="pull-left">
                                                            @if ($sgallery->attachments->last() != null)
                                                                <i class="glyphicon glyphicon-time"></i> <i>{{ $sgallery->attachments->last()->created_at->diffForHumans() }}</i>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row" style="margin:5px">
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">Etiquetas</div>
                <div class="panel-body">
                    @if (count($tags) > 0)
                        {!! Form::open(['route' => 'galleries.index', 'method' => 'GET', 'id' => 'search-form']) !!}
                        <p class="form-inline">
                            {!! Form::text('tags', $request_tags, ['class' => 'form-control', 'id' => 'tags-field']) !!}
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </p>
                        {!! Form::close() !!}
                        @foreach($tags as $tag)
                            <p><a href="" class="tags">{{ $tag }}</a></p>
                        @endforeach
                    @else
                        <i>Ninguna</i>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">Imágenes</div>
                <div class="panel-body">
                    @if (count($attachments) > 0)
                        @foreach($attachments as $attachment)
                            <div class="imageThumb" style="margin: 4px; float: left;">
                                <a href="{{ route('gallery.attachments.index', $attachment->id) }}" role="button" data-toggle="modal" data-target="#ModalShowAttachment" data-url="{{ url('/') }}/attachments/{{ $attachment->file_name }}">
                                    <div class="" style="position: relative; height: 220px;">
                                        <div class="hoverElem" style="position: absolute; top: 0; background: rgba(0,0,0,0.5); width: 100%; color: white; padding: 2px 8px;">
                                            <div style="margin-left: 55px;">
                                                <div><b>Por {{ $attachment->user->nickname }}</b></div>
                                                <div style="font-size: 0.85em">En {{ $attachment->gallery->title }}</div>
                                            </div>
                                        </div>
                                        <div class="hoverElem pull-left" style="position: absolute; margin: 3px 6px;">{!! $attachment->user->profile->ImgAvatar(50,50) !!}</div>
                                        <img src="{{ url('/') }}/attachments/{{ $attachment->file_name }}" style="height: 220px;">
                                        <div style="position: absolute; right: 0; bottom: 0; margin: 4px; color: white; text-shadow: 0 0 4px black;"><i class="glyphicon glyphicon-comment"></i> {{ count($attachment->comments) }}</div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center">
                            <p>Nadie ha subido imágenes {{ $gallery == null ? 'a ninguna galería' : 'a esta galería' }}.{{ Auth::guest() ? '' : ' Sé el primero.' }}</p>
                            <p>
                                @if ( ! Auth::guest())
                                    <a class="btn btn-default btn-lg" role="button" data-toggle="modal" data-target="#ModalCreateAttachment">
                                        <i class="glyphicon glyphicon-plus"></i> Añadir imágenes
                                    </a>
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {!! $attachments->appends(Request::all())->render() !!}
        </div>
    </div>

    <!--
      -- Modals
      -->
    <div class="modal fade" id="ModalCreateAttachment" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Añadir imágenes:</h4>
                </div>
                <div class="modal-body" style="text-align: center">
                    {!! Form::open(['route' => 'galleries.store', 'method' => 'POST', 'files' => true, 'id' => 'form-upload-images']) !!}
                    {!! Auth::guest() ? '' : Form::hidden('user_id', Auth::user()->id) !!}
                    <h2>Seleccionar Galería</h2>
                    <div class="form-group">
                        {!! Form::select('gallery_id', $g_select, $gallery==null ? null : $gallery->id, ['class' => 'form-control', 'id' => 'schild_of', 'required' => 'required']) !!}
                    </div>
                    <p style="font-size: 4.5em;"><i class="fa fa-cloud-upload"></i></p>
                    <p>Por favor seleccione el archivo</p>
                    <p id="selectImageParagraph"><a class="btn btn-primary" role="button" id="selectImageButton">Seleccionar</a></p>
                    <div class="form-group" style="display:none"><input type="file" id="pic" name="pic" multiple='multiple' /></div>
                    <p><i>Se aceptan los formatos <b>jpg, jpeg, png, gif</b></i></p>
                    <div id="imagePreviewRow" class="row" style="margin:5px"></div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    {!! Form::open(['route' => ['galleries.show', $gallery], 'method' => 'GET']) !!}
                    <button type="submit" id="btn-upload-images" class="btn btn btn-primary" disabled>Continuar</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalShowAttachment" tabindex="-1" role="dialog">
        <div class="imgModal">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <img id="attachmentShow" src="" style="">
            <a href="" class="full-size" target="_blank" style="left: 50px; bottom: 5px;" title="Tamaño completo" data-toggle="tooltip" data-placement="top"><i class="glyphicon glyphicon-resize-full"></i></a>
            <a href="" class="info-page" target="" style="left: 5px; bottom: 5px" title="Ver información de la imagen" data-toggle="tooltip" data-placement="top"><i class="glyphicon glyphicon-picture"></i></a>
        </div>
    </div>

    {!! Form::open(['route' => ['gallery.attachments.destroy', ':ATTACHMENT_ID'], 'method' => 'DELETE', 'id' => 'delete-attachment-form']) !!}
    {!! Form::hidden('route', route('gallery.attachments.destroy', ':ATTACHMENT_ID'), ['id' => 'hidden-delete-attachment-route']) !!}
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script id="imagePreviewTemplate" type="text/template">
        <div class="col-md-3">
            <div style="background: darkseagreen; padding: 8px; margin: 8px 0;">
                <div class="imagePreviewLoadingTable">
                    <div class="imagePreviewLoadingTableCell">
                        <div>Subiendo...</div>
                        <div class="loadingBarBorder">
                            <div class="loadingBar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="imagePreviewDelete">
                        <a class="imagePreviewDeleteButton" href="#" title="Eliminar este adjunto"><i class="glyphicon glyphicon-trash"></i></a>
                    </div>
                </div>
                <div><strong>Filename.ext</strong></div>
                <div>Filesize (in kb)</div>
            </div>
        </div>
    </script>
    <script src="{{ url('/') . '/js/galleries_manager.js' }}"></script>
@endsection