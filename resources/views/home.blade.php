@extends('layouts.app')

@section('content')

	<div class="landing-app">
		<img src="/img/device.png" class="device" alt="">
		<a href="https://itunes.apple.com/de/app/greenplatform/id1170382180" target="_blank"><img src="/img/appstore.png" class="app-store" alt=""></a>
		<a href="https://play.google.com/store/apps/details?id=org.greenplatform.gp" target="_blank"><img src="/img/googleplay.png" class="google-play" alt=""></a>
	</div>

	<div class="landing-content">
		<img src="/img/logo.png" alt="">
		<p>
		GreenPlatform is a social orientated platform with the goal to stimulate consumers and business owners to live a greener life. The platform offers users an overview of places rated by visitors. The more leafs a place has, the greener it’s green policy is.
		</p>
		<p>
		Business owners can show their environmental
		and communicate to the world how Green
		their business is.
		</p>
		<p>
			<a href="https://www.facebook.com/greenplatform.org/?fref=ts" class="" target="_blank"><img src="/img/facebook.png" style="width:40px; margin-left:1px" alt=""></a>
		</p>
	</div>

	<div class="landing-features">
		<div class="features-list">
			<div class="features-item">
				<img src="/img/feature-heart.png" alt="">
				<p>
					Be inspired or inspire others with tips on how to live a greener live.
				</p>
			</div>
			<div class="features-item">
				<img src="/img/feature-leaf.png" alt="">
				<p>
					Rate and review companies about their Green policy.
				</p>
			</div>
			<div class="features-item">
				<img src="/img/feature-map.png" alt="">
				<p>
					Check out places around you to see how Green they are.
				</p>
			</div>
			<div class="features-item">
				<img src="/img/feature-plus.png" alt="">
				<p>
					Promote your business with a dedicated page and show how Green you are!
				</p>
			</div>
		</div>
	</div>

@endsection
