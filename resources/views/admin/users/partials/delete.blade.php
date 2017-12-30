{!! Form::open(['route' => ['admin.users.destroy', $user], 'method' => 'DELETE']) !!}
    <button type="submit" onclick="return confirm('¿Seguro que desea eliminar?')" class="btn btn-danger">
        <i class="glyphicon glyphicon-trash"></i> Eliminar usuario
    </button>
{!! Form::close() !!}
