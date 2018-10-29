@extends('layouts.app')

@section('content')
	<div class="landing-content">
		<div class="container-fluid">
			<div class="row home">

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div> <!-- end .flash-message -->


				<div class="col-sm-7">
					<div class="hidden-sm-down">
						<p><span style="font-weight: bold">GreenPlatform - the app that shows your green contribution</span><br>For a sustainable future we need a greener planet. What is your contribution? GreenPlatform gives you the opportunity to show the world how green your business, ngo, organisation, school, restaurant or charity is.
            </p>
            <p><span style="font-weight: bold">Show your efforts for making the planet greener</span><br>Join the GreenPlatform app today and show your customers, contacts and clients what your efforts and responsibilities are for making your environment and our planer greener. Be inspired and benefit from the sustainable solutions of other businesses, ngo’s, restaurants, hospitals and venues. On GreenPlatform you find tips, advice and suggestions for free.<br>
            You can also contact GreenPlatform (<a href="mailto:info@greenplatform.org">info@greenplatform.org</a>) if you would like our professionals to start your account.
            </p>
            <p><span style="font-weight: bold">Social responsibility rewards</span><br>GreenPlatform enables you to earn and assign ‘social responsibility rewards’ (green leaves) and green certificates for free. With the app you can rate and reward responsible and environmental-friendly companies, entrepreneurs, sport clubs, leisure venues and hotels. GreenPlatform also gives businesses, ngo’s and other organisations the opportunity to map reviews and likes they have been given by others.
            </p>
            <p><span style="font-weight: bold">Set your green goals with the app</span><br>With GreenPlatform you can set green goals, get reviews, rewards and certificates. Show and promote your contribution for increasing a greener future for our planet. The GreenPlatform-app is quick to install and easy to use. Download the GreenPlatform-app or join our online platform (<a href="https://www.greenplatform.org/">www.greenplatform.org</a>) today and help to create a greener planet.
            </p>
						<br>
						<a href="https://www.facebook.com/greenplatform.org/?fref=ts" target="_blank" class="social-link"><i class="fa fa-facebook"></i></a>
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
                      <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" placeholder="Firstname" required>

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
                      <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" placeholder="Lastname" required>

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
                      <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="eMail address" required>

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
                      <input type="password" class="form-control" name="password"placeholder="Password" required>

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
                      <input type="password" class="form-control" name="password_confirmation" placeholder="Re-enter Password" required>

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
                    <button type="submit" class="btn">
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
