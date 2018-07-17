@extends('layouts.appcompany')

@section('content')


		<div class="container-fluid main-content">
			<div class="row">
				<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
					<section class="box-typical">
						<div class="profile-card">
							<div class="profile-card-photo">
								@if($page->user_id > 1)
									<div class="taken-checkmark"></div>
								@endif
								@if(count($page->photos)>0)
									<img src="/photos/{{ $page->photos[0]->id }}.jpg" alt=""/>
								@else
									<img src="/img/default-company.png" alt=""/>
								@endif
							</div>

							@for($i = 0; $i < 5; $i++)<img src="/img/leaf-120.png" style="width:28px; display:inline-block; @if($page->rating-1 < $i) opacity:0.3 @endif">@endfor
							<div class="profile-card-name">{{ $page->title}}</div>
							<div class="profile-card-location">{{ $page->address }}</div>
							{{-- <button type="button" class="btn btn-rounded">Follow</button> --}}
							<div id="share"></div>
						</div><!--.profile-card-->

						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
									<b>{{ $page->quiz_score }}</b>
									GP Standard
								</div>
								<div class="tbl-cell">
									<b>{{ count($page->followed) }}</b>
									Followers
								</div>
							</div>
						</div>
					</section><!--.box-typical-->
          @if($page->user_id == 1 && Auth::check())
            <a href="/pages/claim/{{ $page->id }}">
              <button type="button" class="btn btn-rounded">Claim this CompanyPage</button>
            </a>
          @endif

          <!-- Map and marker -->
            <input type="hidden" id="lat" value="{{ $lat }}">
            <input type="hidden" id="lng" value="{{ $lng }}">
            <input type="hidden" id="title" value="{{ $page->title }}">
          <div id="map">
          </div>
        </div><!--.col- -->
				<div class="col-lg-6 col-lg-push-3 col-md-12">
					<section class="box-typical">
						<div class="p-a-md">
              @if($page->user_id == $cuser_id )
                <input type="hidden" id="pageid" value="{{ $page->id }}">
                <div class="text-block text-block-typical" id="textabout">
                  <input type="hidden" id="txt_about_org" value="{{ $page->about }}">
                    {{ $page->about }}
                  <button type="button" id="editabout" class="btn btn-rounded">Edit</button>
                </div>
                <div class="profile-interests" id="textcategories" style="margin-top:30px">
                  <input type="hidden" id="txt_categories_org" value="{{ $page->categories }}">
                  @foreach(explode(',',$page->categories) as $category)
                    <a href="#" class="label label-light-grey">{{ $category }}</a>
                  @endforeach
                  <button type="button" id="editcat" class="btn btn-rounded">Edit</button>
                </div>
              @else
                <div class="text-block text-block-typical">
                {{ $page->about }}
                </div>
                <div class="profile-interests" style="margin-top:30px">
                @foreach(explode(',',$page->categories) as $category)
                  <a href="#" class="label label-light-grey">{{ $category }}</a>
                 @endforeach
                </div>
              @endif
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
						@if(count($page->photos) == 0)
							<div style="padding:18px">This company has no photos uploaded</div>
						@else
							<div class="posts-slider">
								@foreach($page->photos as $photo)
									<div class="slide">
										<article class="post-announce">
											<div class="post-announce-pic">
												<a href="#">
													<a class="venobox" href="/photos/{{ $photo->id }}.jpg"><img src="/photos/{{ $photo->id }}_thumb.jpg" alt=""></a>
												</a>
											</div>
										</article>
									</div><!--.slide-->

								@endforeach

							</div><!--.posts-slider-->
						@endif
            @if($page->user_id == $cuser_id )
            <form method="POST" action="/pages/{{ $page->id }}/images" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="file" name="photo"></input>
              <button class="btn" type="submit">Add Image</button>
            </form>
            @endif
					</section><!--.box-typical-->

					<section class="box-typical">
						<header class="box-typical-header-sm">
							Reviews
						</header>

						@if(count($page->reviews)>0)

							@foreach($page->reviews as $review)

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
								This page has no reviews yet.
							</div>
						@endif

					</section>

					<section class="box-typical">
						<header class="box-typical-header-sm">
							GP Standard
						</header>

						@if(count($page->quizAnswers)>0)

							@foreach($page->quizAnswers as $answer)

								<div class="p-x-md">

									<b>{{ $answer->question_text }}</b>
									<p>{{ $answer->answer }}</p>

								</div>

							@endforeach

						@else
							<div class="p-a-md">
								This company didn't complete the GP Standard quiz yet.
							</div>
						@endif

					</section>


				</div><!--.col- -->

				<div class="col-lg-3 col-md-6 col-sm-6">

					<section class="box-typical">
						<header class="box-typical-header-sm">Updates {{ $page->num_updates }}</header>

              @foreach($page->updates as $update)

                <div class="p-x-md">

                  <b>{{ $update->formatted_date }}</b>
                  <b>{{ $update->content }}</b>
                  <b>{{ $update->kind }}</b>
                  <b>{{ $update->user_id }}</b>
                </div>

              @endforeach

					</section><!--.box-typical-->
				</div><!--.col- -->
			</div><!--.row-->
		</div><!--.container-fluid-->
@endsection
