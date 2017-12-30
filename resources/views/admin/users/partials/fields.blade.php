    <div class="form-group">
        {!! Form::label('email', 'Correo Electrónico') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Inserte aquí su correo marikon pendejo jeje']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', 'Contraseña') !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese contraseña']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('nickname', 'Seudónimo') !!}
        {!! Form::text('nickname', null, ['class' => 'form-control', 'placeholder' => 'Alias ó seudónimo (Nickname)']) !!}
    </div>
    <div class="form-inline">
        {!! Form::label('firstname', 'Nombre') !!}
        {!! Form::text('firstname', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
        {!! Form::label('lastname', 'Apellido') !!}
        {!! Form::text('lastname', null, ['class' => 'form-control', 'placeholder' => 'Apellido']) !!}
        {!! Form::hidden('fullname', 'Nombre completo') !!}
    </div>
    <div class="form-group">
        {!! Form::label('type', 'Tipo de usuario') !!}
        {!! Form::select('type', config('options.types'), null, ['class' => 'form-control']) !!}
    </div>
