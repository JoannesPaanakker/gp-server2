@extends('layouts.app')

@section('content')


		<div class="container-fluid main-content">
			<div class="row">
				<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">

					<section class="box-typical">
						<div class="profile-card">
							<div class="profile-card-photo">
								@if($user->picture)
									<img src="{{ $user->picture }}" alt=""/>
								@else
									<img src="/img/avatar-sign.png" alt=""/>
								@endif
							</div>
							@for($i = 0; $i < 5; $i++)<img src="/img/leaf-120.png" style="width:28px; display:inline-block; @if($user->rating-1 < $i) opacity:0.5 @endif">@endfor
							<div class="profile-card-name">{{ $user->first_name}} {{ $user->last_name}}</div>
							{{-- <button type="button" class="btn btn-rounded">Follow</button> --}}
							<div id="share"></div>
						</div><!--.profile-card-->

						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
									<b>{{ $user->quiz_score }}</b>
									GP Standard
								</div>
								<div class="tbl-cell">
									<b>{{ count($user->followed_by) }}</b>
									Followers
								</div>
							</div>
						</div>


					</section><!--.box-typical-->


				</div><!--.col- -->

				<div class="col-lg-6 col-lg-push-3 col-md-12">


					</section><!--.box-typical-->

					<section class="box-typical">
						<header class="box-typical-header-sm">
							Reviews by {{ $user->first_name}} {{ $user->last_name}}
						</header>

						@if(count($user->reviews) > 0)

							@foreach($user->reviews as $review)

								<div class="p-a-md">

									<div class="citate-speech-bubble">
										<h6>{{ $review->page->title }}</h6>
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