@extends('layouts.app')

@section('content')
	<div class="landing-content">
		<div class="container-fluid">
			<div class="row home">
				<div class="col-sm-7">
					<div class="hidden-sm-down">
						<h4>Greenplatform is the new must have app to save the planet</h4>
						<p>Check, review and reward your favorite bar, supermarket, NGO or school to make a statement. Be in control. Team up now and join your friends, expand your network and show what you are doing to make the world a better place.</p>
						<br>
						<a href="https://www.facebook.com/greenplatform.org/?fref=ts" target="_blank" class="social-link"><i class="fa fa-facebook"></i></a>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>

						<a href="https://itunes.apple.com/app/greenplatform/id1170382180" target="_blank"><img src="/img/download-ios.png" alt="" class="download-button-ios"></a>
						<a href="https://play.google.com/store/apps/details?id=org.greenplatform.gpandroid" target="_blank"><img src="/img/download-android.png" alt="" class="download-button-android"></a>
            <br>
					</div>
				</div>
        <div>
          <div class="form-group">
            <div class="col-md-3">
              <p class="hidden-md-up">Greenplatform is the new must have app to save the planet</p>
              <p class="hidden-md-up">Check, review and reward your favorite bar, supermarket, NGO or school to make a statement. Be in control. Team up now and join your friends, expand your network and show what you are doing to make the world a better place.</p>

              <a href="/fbredirect">
                <button type="button" class="btn"><i class="fa fa-facebook"></i>
                  Register with Facebook
                </button>
              </a>
             <h4 class="hidden-sm-down">or register with eMail:</h4>
             <p class="hidden-md-up">or email-register:</p>
            </div>
          </div>
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/users/register-nohashid') }}">
              {!! csrf_field() !!}

              <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                  <label class="col-md-3 control-label hidden-sm-down">First Name</label>

                  <div class="col-md-3">
                      <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" placeholder="Firstname">

                      @if ($errors->has('firstname'))
                          <span class="help-block">
                              <strong>{{ $errors->first('firstname') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                  <label class="col-md-3 control-label hidden-sm-down">Last Name</label>

                  <div class="col-md-3">
                      <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" placeholder="Lastname">

                      @if ($errors->has('lastname'))
                          <span class="help-block">
                              <strong>{{ $errors->first('lastname') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label class="col-md-3 control-label hidden-sm-down">E-Mail Address</label>

                  <div class="col-md-3">
                      <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="eMail address">

                      @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label class="col-md-3 control-label hidden-sm-down">Password</label>

                  <div class="col-md-3">
                      <input type="password" class="form-control" name="password"placeholder="Password">

                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <label class="col-md-3 control-labe hidden-sm-down">Confirm Password</label>

                  <div class="col-md-3">
                      <input type="password" class="form-control" name="password_confirmation" placeholder="Re-enter Password">

                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-3 control-label">
                    <br>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i> Submit eMail registration
                    </button>
                    <br>
                  </div>
              </div>
          </form>
        </div>
        </div>
			</div>
		</div>

@endsection
