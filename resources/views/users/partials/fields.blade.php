<div class="form-group">
    {!! Form::label('website', 'Sitio web') !!}
    {!! Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'Sitio web']) !!}
</div>
<div class="form-group">
    {!! Form::label('twitter', 'Twitter') !!}
    {!! Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => 'Twitter']) !!}
</div>
<div class="form-group">
    {!! Form::label('bio', 'Bio') !!}
    {!! Form::textarea('bio', null, ['class' => 'form-control', 'placeholder' => 'Acerca de mí']) !!}
</div>
<div class="form-group">
    {!! Form::label('country_id', 'País') !!}
    {!! Form::select('country_id', array_merge(['', '' => 'Seleccione un país'], config('countries.list')), null, ['class' => 'form-control']) !!}
</div>