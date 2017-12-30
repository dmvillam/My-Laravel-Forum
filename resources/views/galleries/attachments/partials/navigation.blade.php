<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <ol class="breadcrumb">
            <li><a href="{{ route('galleries.index') }}"><i class="glyphicon glyphicon-picture"></i> Galerías</a></li>
            <li><a href="{{ route('galleries.show', $attachment->gallery) }}">{{ $attachment->gallery->title }}</a></li>
            <li class="active">{{ $attachment->original_name }}</li>
        </ol>
    </div>
</div>