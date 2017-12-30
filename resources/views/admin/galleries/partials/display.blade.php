<div class="row">
    <div class="col-md-1"><p>{{ $gallery->id }}</p></div>
    <div class="col-md-6" style="position:relative">
        <div style="position: absolute; left: {{ 14 + $child_level * 25 }}px;">
            @if ($gallery->order != 0)
                <a href="#" data-gallery-id="{{ $gallery->id }}" class="up-down-button action-up"><i class="glyphicon glyphicon-arrow-up"></i></a>
            @endif
            @if ($gallery->order != \App\Gallery::where('child_of', '=', $gallery->child_of)->orderBy('order', 'ASC')->get()->last()->order)
                <a href="#" data-gallery-id="{{ $gallery->id }}" class="up-down-button action-down"><i class="glyphicon glyphicon-arrow-down"></i></a>
            @endif
        </div>
        <div style="position: absolute; left: {{ 50 + $child_level * 25 }}px;">
            <a href="" title="{{ $gallery->desc }}">
                <i class="glyphicon glyphicon-th-list"></i>
                {{ $gallery->title }}
            </a>
        </div>
    </div>
    <div class="col-md-1"><p>{{ $gallery->order }}</p></div>
    <div class="col-md-4">
        <p>
            <a href="#" class="btn btn-primary btn-xs" title="Añadir subgalería" data-gallery-id="{{ $gallery->id }}" role="button" data-toggle="modal" data-target="#ModalCreateGallery"><i class="glyphicon glyphicon-plus"></i></a>
            <a href="#" title="Modificar" data-gallery-title="{{ $gallery->title }}" data-gallery-id="{{ $gallery->id }}" data-gallery-desc="{{ $gallery->desc }}" data-gallery-child-of="{{ $gallery->child_of }}" data-toggle="modal" data-target="#ModalEditGallery"><i class="glyphicon glyphicon-pencil"></i></a>
            <a href="#" title="Eliminar" data-gallery-title="{{ $gallery->title }}" data-gallery-id="{{ $gallery->id }}" data-toggle="modal" data-target="#ModalDeleteGallery"><i class="glyphicon glyphicon-trash"></i></a>
        </p>
    </div>
</div>

@foreach(\App\Gallery::where('child_of', '=', $gallery->id)->orderBy('order', 'ASC')->get() as $subgallery)
    @include('admin.galleries.partials.display', ['gallery' => $subgallery, 'child_level' => $child_level + 1])
@endforeach