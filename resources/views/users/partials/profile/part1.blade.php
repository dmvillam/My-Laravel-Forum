<div class="panel panel-default">
    <div class="panel-heading">
        {{ $user->nickname }}
    </div>
    <div class="panel-body">
            <div class="PULL-RIGHT">
                {!! $user->profile->ImgAvatar(75,75,'') !!}
            </div>
            <div class="">
                <p>{{ config('options.types')[$user->type] }}</p>
                <p><strong>Fecha de registro:</strong> <i>{{ $user->created_at ? $user->created_at->format('M Y') : 'Nula' }}</i></p>
                <p><strong>Sexo:</strong> {!! $user->profile->icon_gender !!}</p>
                <p><strong>Otros campos personalizados:</strong> <i>Que si humor / ubicación / alineación / etc.</i></p>
                <p><strong>Hilos:</strong> {{ count($user->threads) }}</p>
                <p><strong>Posts:</strong> {{ count($user->posts) }}</p>
            </div>
    </div>
</div>

@if ($user->profile->signature != null)
    <div class="panel panel-default">
        <div class="panel-heading">
            Firma de {{ $user->nickname }}
        </div>
        <div class="panel-body">
            {!! $user->profile->clean_signature !!}
        </div>
    </div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        Social
    </div>
    <div class="panel-body">
        Amigos de {{ $user->nickname }}
        <hr>
        {{ $user->nickname }} está siguiendo a:
        <hr>
        Seguidores de {{ $user->nickname }}:
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Galerías de {{ $user->nickname }}
    </div>
    <div class="panel-body">
        Galerías.
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Blog: Últimas entradas de {{ $user->nickname }}
    </div>
    <div class="panel-body">
        Entradas.
    </div>
</div>

<!--
  -- Modals
  -->
