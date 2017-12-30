{{--
  -- Modals
  --}}
{!! Form::open(['url' => 'login', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
<div class="modal fade" id="ModalLogIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('', 'E-Mail Address', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::email('email', old('email'), ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('', 'Password', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>{!! Form::checkbox('remember', null) !!} Remember Me</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-sign-in"></i>Login</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
