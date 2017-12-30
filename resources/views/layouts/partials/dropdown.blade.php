{{--
  -- Popover content
  --}}
<ul class="dropdown-menu" role="menu">
    <li class="dropdown-header">
        <div class="row">
            <div class="col-md-4">
                {!! Auth::user()->profile->ImgAvatar(60,60,'img-rounded') !!}
            </div>
            <div class="col-md-8">
                <div><strong>{{ Auth::user()->nickname }}</strong></div>
                <div>{{ config('options.types')[Auth::user()->type] }}</div>
            </div>
        </div>
    </li>
    <li><a href="{{ url('/users/' . Auth::user()->id) }}"><i class="fa fa-btn fa-user"></i>Ver perfil</a></li>
    <li role="separator" class="divider"></li>
    <li><a href=""><i class="glyphicon glyphicon-paperclip"></i> Mis adjuntos</a></li>
    <li><a href=""><i class="glyphicon glyphicon-cog"></i> Configuración</a></li>
    <li role="separator" class="divider"></li>
    <li><a href=""><i class="glyphicon glyphicon-eye-open"></i> Panel de Moderación</a></li>
    @if (Auth::user()->type == 'admin')
        <li><a href="{{ url('admin/index') }}"><i class="glyphicon glyphicon-lock"></i> Panel de Administración</a></li>
    @endif
    <li role="separator" class="divider"></li>
    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
</ul>
