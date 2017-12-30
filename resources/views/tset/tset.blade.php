@extends('layouts.app')

@section('content')
    <div class="container">
        <p>Prueba probando</p>
        <blockquote>
            <p>
                I must express my disbelief without resulting to vulgarities, good sirs.
                I can barely say in between fits of unrestrained mirth.
                I almost lost my seating with that last outburst, and it has not subsided yet. My goodness.
                This is indeed, if I may be so bold as to use the common tongue, and excrement of unrivaled worth.
                Again, I say these things in the moments between unparalleled fits of laughter.
                It is the biggest of it's kind, as well as the greatest.
                I congratulate you on your efforts, and the efforts of all those involved.
            </p>
            <p>
                las perras estan sobrevaloradas no ay nada como salir a rasparte la cara en el pavimento
                y sentir la adrenalina correr por tus venas cuando el viento choca en tu cara y ese
                sentimiento de fuerza y precision extrema que al aer todos tus tendones y musculos chocan
                conra el suelo y sientes la necesidad de correr pues no tieneslimites y
                casi sientes como si pudieras volar
            </p>
        </blockquote>
        <p>Jeje es neta.</p>
        <p>Php self: {{ $_SERVER['PHP_SELF'] }}</p>
        <p>Ip: {{ $_SERVER['REMOTE_ADDR'] }}</p>

        <h1>TinyMCE Inline Editing Mode Guide</h1>
        <form method="post">
            <div id="myeditablediv">Click here to edit!</div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#myeditablediv',
            inline: true
        });
    </script>
@endsection