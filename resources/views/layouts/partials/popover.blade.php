{{--
  -- Popover content
  --}}
<div id="user-account" style="display: none">
    @if ( ! Auth::guest())
        <div class="row">
            <div class="col-md-4">
                {!! Auth::user()->profile->ImgAvatar(60,60,'img-rounded') !!}
            </div>
            <div class="col-md-8">
                <div><h4>{{ Auth::user()->nickname }}</h4></div>
                <div>{{ config('options.types')[Auth::user()->type] }}</div>
                <p>

                </p>
            </div>
        </div>
        <div class="panel-default"><div class="panel-heading">Mi Cuenta</div></div>
        <div class="list-group">
            <a href="{{ route('users.profile', Auth::user()) }}" class="list-group-item">
                <i class="glyphicon glyphicon-user"></i>
                Ver perfil
            </a>
            <a href="" class="list-group-item"><i class="glyphicon glyphicon-paperclip"></i> Mis adjuntos</a>
            <a href="" class="list-group-item"><i class="glyphicon glyphicon-cog"></i> Configuración</a>
        </div>
        <div class="list-group">
            <a href="" class="list-group-item"><i class="glyphicon glyphicon-eye-open"></i> Panel de Moderación</a>
            <a href="" class="list-group-item"><i class="glyphicon glyphicon-lock"></i> Panel de Administración</a>
        </div>
        <div class="list-group">
            <a href="{{ url('/logout') }}" class="list-group-item"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
        </div>
    @else
    @endif
</div>