@extends('layouts.appcompany')

@section('content')


		<div class="container-fluid main-content">
			<div class="row">
				<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
        <!-- Follow this page -->
          @if(Auth::check() && $follows == false)
            @include('partials.followpage')
          @endif
        <!-- end of Follow this page -->
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
                  <!-- 0 if no score -->
									<b>{{ $total_score }}</b>
                  @include('partials.pagegpanswers')
								</div>
								<div class="tbl-cell">
									<b>{{ count($page->followed) }}</b>
                  @include('partials.pagefollowers')
								</div>
							</div>
						</div>
					</section><!--.box-typical-->
          @if( Auth::check() && $page->user_id == 1 )
            <a href="/pages/claim/{{ $page->id }}">
              <button type="button" class="btn">Claim {{ $page->title}}</button>
            </a>
          @endif
          <section>
          <!-- Map and marker -->
            <input type="hidden" id="lat" value="{{ $lat }}">
            <input type="hidden" id="lng" value="{{ $lng }}">
            <input type="hidden" id="title" value="{{ $page->title }}">
          <div id="map">
          </div>
          </section>
        </div><!--.col- -->


        <div class="col-lg-6 col-lg-push-3 col-md-12">
        <section class="box-typical">
						<div class="p-a-md">
              @if( ( Auth::check() && $page->user_id == 1 ) || ( Auth::check() && $page->user_id == Auth::user()->id ) )
                <input type="hidden" id="pageid" value="{{ $page->id }}">
                <div class="text-block text-block-typical" id="textabout">
                  <input type="hidden" id="txt_about_org" value="{{ $page->about }}">
                    {{ $page->about }}
                  <button type="button" id="editabout" class="btn">Edit</button>
                </div>
                <div class="profile-interests" id="textcategories" style="margin-top:30px">
                  <input type="hidden" id="txt_categories_org" value="{{ $page->categories }}">
                  @foreach(explode(',',$page->categories) as $category)
                    <a href="#" class="label label-light-grey">{{ $category }}</a>
                  @endforeach
                  <button type="button" id="editcat" class="btn">Edit</button>
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

        @if( ( Auth::check() && $page->user_id == 1 ) || ( Auth::check() && $page->user_id == Auth::user()->id ) )
          @include('partials.addphoto')
        @endif
					<section class="box-typical">
            <div class="p-a-md">
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
							<div style="padding:18px">{{ $page->title}} has no photos uploaded</div>
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
          </div>
					</section><!--.box-typical-->
          @if( Auth::check())
            @include('partials.review')
          @endif
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
                    @if($review->picture)
                      <img class="fit" src="{{ $review->picture }}" alt="image"/>
                    @endif
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
				</div><!--.col- -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<section class="box-typical">
						<header class="box-typical-header-sm">Updates {{ $page->num_updates }}</header>
            @foreach($page->updates as $update)
              <div class="p-x-md">
                <b>{{ $update->formatted_date }}</b>
                {{ $update->user->first_name }} {{ $update->user->last_name }} {{ $update->content }} for {{ $update->page->title }}
              </div>
            @endforeach
					</section><!--.box-typical-->
				</div><!--.col- -->
			</div><!--.row-->
		</div><!--.container-fluid-->
@endsection
