@extends('layouts.appuser')

@section('content')

  @if(Auth::check())
		<div class="container-fluid main-content">
			<div class="row">
				<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
          <section>
            @if($user->id == Auth::user()->id)
              <div id="updateprofileimage">
                <button class="btn" id="update-profile-image-button">Change Profile Image</button>
              </div>
            @else
              @if ($follows == false)
                @include('partials.followuser')
              @endif
            @endif
          </section>
					<section class="box-typical">
						<div class="profile-card">
							<div class="profile-card-photo">
								@if($user->picture)
									<img src="{{ $user->picture }}" alt="{{ $user->first_name}} {{ $user->last_name}}'s profile image"/>
								@else
									<img src="/img/avatar-sign.png" alt="standard profile image"/>
								@endif
							</div>
							@for($i = 0; $i < 290; $i = $i + 60)<img src="/img/feature-leaf.png" style="width:32px; display:inline-block; @if($user->quiz_score < $i) opacity:0.3 @endif">@endfor
							<div class="profile-card-name">{{ $user->first_name}} {{ $user->last_name}}</div>
							<!-- <button type="button" class="btn btn-rounded">Follow</button> -->
							<div id="share"></div>
						</div><!--.profile-card-->
						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
                  GP score:<b>{{ $total_score }}</b>
                  @include('partials.gpanswers')
								</div>
								<div class="tbl-cell">
                  Followers <b>{{ count($user->followed_by)}}</b>
                  @include('partials.followers')
								</div>
							</div>
						</div>
					</section><!--.box-typical-->
          <section>
          </section>
          <section>
            @if($user->id == Auth::user()->id)
              <button class="btn" id="update-bio-button">Change Bio</button>
            @endif
          </section>
          <section class="box-typical">

              <div class="profile-card">
                <div class="box-typical">
                  <input type="hidden" id="updatebiotext" value="{{ $user->bio }}">
                  <b>This is me</b>
                  <div id="updatebio">
                    {{ $user->bio }} <br>
                  </div>
                </div>

              </div>

          </section>
        </div><!--.col- -->
				<div class="col-lg-6 col-lg-push-3 col-md-6 col-sm-6">
          @if($user->id == Auth::user()->id)
            <section class="box-typical">
              <header class="box-typical-header-sm">Activities Communitiy</header>
              <div class="p-a-md">
                <div class="tbl-cell">
                  @foreach( $user->feeds as $feet )
                    <b>{{ $feet->formatted_date }} </b>
                    <p>{{ $feet->user->first_name}} {{ $feet->user->last_name}} {{ $feet->content}} on {{ $feet->entity_name}}</p>
                  @endforeach
                </div>
              </div>
              <header class="box-typical-header-sm">My Activities</header>
              <div class="p-a-md">
                <div class="tbl-cell">
                  @foreach( $user->feed as $feed)
                    <b>{{ $feed->formatted_date }}</b>
                    <p>{{ $feed->content }} {{ $feed->entity_name }}</p>
                  @endforeach
                </div>
              </div>
            </section><!--.box-typical-->
          @endif
  				<section class="box-typical">
						<header class="box-typical-header-sm">
							Reviews by {{ $user->first_name}} {{ $user->last_name}}
						</header>

						@if(count($user->reviews) > 0)

							@foreach($user->reviews as $review)

								<div class="p-a-md">

									<div class="citate-speech-bubble">
										<h6>{{ @$review->page->title }}</h6>
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
								This user has no reviews yet.
							</div>
						@endif
					</section>
				</div><!--.col- -->
        @if($user->id == Auth::user()->id)
          @include('partials.addgoal')
        @endif
        <div class="col-lg-3 col-md-6 col-sm-6">
          <section class="box-typical">
            <header class="box-typical-header-sm">Goals set by {{ $user->first_name}} {{ $user->last_name}}</header>
            <div class="p-a-md">
              <div class="tbl-cell">
                @foreach( $user->goals as $goal )
                  <b>{{ $goal->title }} </b>
                  <p>{{ $goal->content}} </p>
                  <div class="progress fits">
                    <div class="progress-bar" role="progressbar"
                    aria-valuenow="{{ $goal->progress}}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $goal->progress}}%">
                      {{ $goal->progress}}%
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </section><!--.box-typical-->
        </div><!--.col- -->
        @if($user->id == Auth::user()->id)
          @include('partials.addtip')
        @endif
        <div class="col-lg-3 col-md-6 col-sm-6">
          <section class="box-typical">
            <header class="box-typical-header-sm">Green tips from {{ $user->first_name}} {{ $user->last_name}}</header>
            <div class="p-a-md">
              <div class="tbl-cell">
                @foreach( $user->tips as $tip )
                  <b>{{ $tip->title }} </b>
                  <p>{{ $tip->content }}</p>
                  <div class="tbl-cell-photo">
                    <img src="{{ $tip->picture }}" alt="" class="fit">
                  </div>
                @endforeach
              </div>
            </div>
          </section><!--.box-typical-->
          @include('partials.companiesfollowing')
          @include('partials.usersfollowing')
          <section class="box-typical">
            <header class="box-typical-header-sm">
              Review Pages managed by {{ $user->first_name}} {{ $user->last_name}}
            </header>
                <div class="p-a-md">
            @if(count($user->pages) > 0)
              @foreach($user->pages as $page)
                  <div class="user-card-row">

                      <div class="tbl-cell tbl-cell-photo">
                        @if(count($page->photos)>0)
                          <img src="/photos/{{ $page->photos[0]->id }}.jpg" alt=""/>
                        @else
                          <img src="/img/default-company.png" alt=""/>
                        @endif

                      </div>
                    <h5><a href="/{{ $page->slug }}/{{ $page->id }}?current_user_id={{ $user->id }}">{{ $page->title }}</a></h5>
                  </div>
                  <br>
              @endforeach
                </div>

            @else
              <div class="p-a-md">
                This user has no pages yet.
              </div>
            @endif
          </section>
        </div><!--.col- -->
			</div><!--.row-->
		</div><!--.container-fluid-->

    <script>
      var updateprofileimagebutton = document.getElementById("update-profile-image-button");
      updateprofileimagebutton.addEventListener("click", updateProfileImage );

      function updateProfileImage() {
        document.getElementById("updateprofileimage").innerHTML='<form method="POST" action="/users/{{ $user->id }}/upload-profile-image-page" enctype="multipart/form-data">{{ csrf_field() }}<input type="file" name="photo"></input><button type="submit" class="btn">Save Profile Image</button></form>';
      }

      var updatebiobutton = document.getElementById("update-bio-button");
      updatebiobutton.addEventListener("click", updateBio );
      var updatebiotext = document.getElementById("updatebiotext").value;

      function updateBio() {
        document.getElementById("updatebio").innerHTML='<form method="POST" action="/users/{{ $user->id }}/update-bio-page">{{ csrf_field() }}<textarea type="text" name="bio">' + updatebiotext + '</textarea><button type="submit" class="btn">Save Bio</button></form>';

        var tx = document.getElementsByTagName('textarea');
        for (var i = 0; i < tx.length; i++) {
          tx[i].setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px;overflow-y:hidden;');
          tx[i].addEventListener("input", OnInput, false);
        }
        function OnInput() {
          this.style.height = 'auto';
          this.style.height = (this.scrollHeight) + 'px';
        }
      }

    </script>
@else
      <p>Your Greenplatform session expired. PLease go to the HomePage tot login:</p>
      <a href="/" class="site-logo">
          Homepage:
          <img src="/img/leaf-120.png" alt="">
      </a>
      <br><br>
@endif

@endsection
