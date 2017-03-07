@extends('layouts.app')

@section('content')


		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">

					<section class="box-typical">
						<div class="profile-card">
							<div class="profile-card-photo">
								@if($user->picture)
									<img src="{{ $user->picture }}" alt=""/>
								@else
									<img src="/img/faq-3.png" alt=""/>
								@endif
							</div>
							@for($i = 0; $i < 5; $i++)<img src="/img/leaf-120.png" style="width:28px; display:inline-block; @if($user->rating-1 < $i) opacity:0.5 @endif">@endfor
							<div class="profile-card-name">{{ $user->first_name}} {{ $user->last_name}}</div>
							{{-- <button type="button" class="btn btn-rounded">Follow</button> --}}

						</div><!--.profile-card-->

						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
									<b>300</b>
									GP Standard
								</div>
								<div class="tbl-cell">
									<b>200</b>
									Followers
								</div>
							</div>
						</div>

						<ul class="profile-links-list">
							<li class="nowrap">
								<i class="font-icon font-icon-earth-bordered"></i>
								<a href="#">website.com</a>
							</li>
							<li class="nowrap">
								<i class="font-icon font-icon-fb-fill"></i>
								<a href="#">facebook.com/username</a>
							</li>
							<li class="nowrap">
								<i class="font-icon font-icon-in-fill"></i>
								<a href="#">linked.in/user</a>
							</li>
							<li class="nowrap">
								<i class="font-icon font-icon-tw-fill"></i>
								<a href="#">twitter.com/user</a>
							</li>
							<li class="divider"></li>
							<li>
								<i class="font-icon font-icon-mail"></i>
								<a href="#">Email this user</a>
							</li>
						</ul>
					</section><!--.box-typical-->


				</div><!--.col- -->

				<div class="col-lg-6 col-lg-push-3 col-md-12">


					<section class="box-typical">

						<div class="p-a-md">


						</div>
					</section><!--.box-typical-->


					<section class="box-typical">
						<header class="box-typical-header-sm">
							Photos
							<div class="slider-arrs">
								<button type="button" class="posts-slider-prev">
									<i class="font-icon font-icon-arrow-left"></i>
								</button>
								<button type="button" class="posts-slider-next">
									<i class="font-icon font-icon-arrow-right"></i>
								</button>
							</div>
						</header>
						<div class="posts-slider">

							<div class="slide">
								<article class="post-announce">
									<div class="post-announce-pic">
										<a href="#">
											<img src="/img/post-1.jpeg" alt="">
										</a>
									</div>
								</article>
							</div><!--.slide-->

							<div class="slide">
								<article class="post-announce">
									<div class="post-announce-pic">
										<a href="#">
											<img src="/img/post-2.jpg" alt="">
										</a>
									</div>
								</article>
							</div><!--.slide-->

							<div class="slide">
								<article class="post-announce">
									<div class="post-announce-pic">
										<a href="#">
											<img src="/img/post-3.jpeg" alt="">
										</a>
									</div>
								</article>
							</div><!--.slide-->

							<div class="slide">
								<article class="post-announce">
									<div class="post-announce-pic">
										<a href="#">
											<img src="/img/post-1.jpeg" alt="">
										</a>
									</div>
								</article>
							</div><!--.slide-->

							<div class="slide">
								<article class="post-announce">
									<div class="post-announce-pic">
										<a href="#">
											<img src="/img/post-2.jpg" alt="">
										</a>
									</div>
								</article>
							</div><!--.slide-->

							<div class="slide">
								<article class="post-announce">
									<div class="post-announce-pic">
										<a href="#">
											<img src="/img/post-3.jpeg" alt="">
										</a>
									</div>
								</article>
							</div><!--.slide-->
						</div><!--.posts-slider-->
					</section><!--.box-typical-->

					<section class="box-typical">
						<header class="box-typical-header-sm">
							Reviews
						</header>

						@if(count($user->reviews)>0)

							@foreach($user->reviews as $review)

								<div class="p-a-md">

									<div class="citate-speech-bubble">
										<b>{{ $review->title }}</b>
										<p>{{ $review->content }}</p>
									</div>
									<div class="user-card-row">
										<div class="tbl-row">
											<div class="tbl-cell tbl-cell-photo">
												<a href="#" tabindex="0">
													<img src="{{ $review->user->picture }}" alt="">
												</a>
											</div>
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="#" tabindex="0">{{ $review->user->first_name }} {{ $review->user->last_name }}</a></p>
											</div>
										</div>
									</div>

								</div>

							@endforeach

						@else
							<div class="p-a-md">
								This user has no reviews yet.
							</div>
						@endif

					</section>

					<section class="box-typical">
						<header class="box-typical-header-sm">
							GP Standard
						</header>

						@if(count($user->quizAnswers)>0)

							@foreach($user->quizAnswers as $answer)

								<div class="p-x-md">

									<b>{{ $answer->question_text }}</b>
									<p>{{ $answer->answer }}</p>

								</div>

							@endforeach

						@else
							<div class="p-a-md">
								This user didn't complete the GP Standard quiz yet.
							</div>
						@endif

					</section>


				</div><!--.col- -->

				<div class="col-lg-3 col-md-6 col-sm-6">

					<section class="box-typical">
						<header class="box-typical-header-sm">About GreenPlatform</header>

						<div class="p-a-md">
							GreenPlatform is a social orientated platform with the goal to stimulate consumers and business owners to live a greener life. The platform offers users an overview of places rated by visitors. The more leafs a place has, the greener it’s policy is.
						</div>

					</section><!--.box-typical-->
				</div><!--.col- -->
			</div><!--.row-->
		</div><!--.container-fluid-->

@endsection