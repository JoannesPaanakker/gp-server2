@extends('layouts.appuser')

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
							<!-- <button type="button" class="btn btn-rounded">Follow</button> -->
							<div id="share"></div>
						</div><!--.profile-card-->
						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
									<b>{{ $user->quiz_score }}</b>
									GP Standard
								</div>
								<div class="tbl-cell">
                  Followers
                  @foreach( $user->followed_by as $follow)
				  					<b>{{ $follow->id }}</b>
                  @endforeach
								</div>
                <div class="tbl-cell">
                  You are following these users:
                 @foreach( $user->following_users as $following_user)
                    <b>{{ $following_user->id }}</b>
                  @endforeach
                </div>
                <div class="tbl-cell">
                 You are following these companies:
                 @foreach( $user->following_pages as $following_page)
                    <b>{{ $following_page->id }}</b>
                  @endforeach
                </div>
							</div>
						</div>
					</section><!--.box-typical-->
          <section>
          </section>
          <section>
            @if($user->id == Auth::user()->id)
              <div id="updateprofileimage">
                <button class="btn" id="update-profile-image-button">Change Profile Image</button>
              </div>
            @else
              @include('partials.followuser')
            @endif
          </section>
          <section class="box-typical">

              <div class="profile-card">
                <div class="box-typical">
                  <input type="hidden" id="updatebiotext" value="{{ $user->bio }}">
                  <b>This is me</b>
                  <div id="updatebio">
                    {{ $user->bio }} <br>
                  @if($user->id == Auth::user()->id)
                    <button class="btn" id="update-bio-button">Change Bio</button>
                  @endif
                  </div>
                </div>

              </div>

          </section>
				</div><!--.col- -->

				<div class="col-lg-6 col-lg-push-3 col-md-6 col-sm-6">
          <section class="box-typical">
            <header class="box-typical-header-sm">
              Pages managed by {{ $user->first_name}} {{ $user->last_name}}
            </header>
            @if(count($user->pages) > 0)

              @foreach($user->pages as $page)
                <div class="p-a-md">

                  <div class="citate-speech-bubble">
                    <h6><a href="/page/{{ $page->slug }}/{{ $page->unique_id }}?current_user_id={{ $user->id }}">{{ $page->title }}</a></h6>
                    <div>
                      <b class="text-block-input">{{ $page->about }}</b>
                    </div>
                  </div>
                  <div class="user-card-row">
                    <div class="tbl-row">
                      <div class="tbl-cell tbl-cell-photo">
                        @if(count($page->photos)>0)
                          <img src="/photos/{{ $page->photos[0]->id }}.jpg" alt=""/>
                        @else
                          <img src="/img/default-company.png" alt=""/>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

              @endforeach

            @else
              <div class="p-a-md">
                This user has no pages yet.
              </div>
            @endif
          </section>

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
						@if(count($user->quiz_answers)>0)

							@foreach($user->quiz_answers as $answer)

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
            <header class="box-typical-header-sm">Feeds</header>

            <div class="p-a-md">
              <div class="tbl-cell">
@foreach( $user->feeds as $feet )
<b>{{ $feet->formatted_date }}</b>
<p>{{ $feet->entity_name}} {{ $feet->content}}</p>
@endforeach
              </div>
            </div>

          </section><!--.box-typical-->
        </div><!--.col- -->
        <div class="col-lg-3 col-md-6 col-sm-6">

          <section class="box-typical">
            <header class="box-typical-header-sm">Feed</header>

            <div class="p-a-md">
              <div class="tbl-cell">
                @foreach( $user->feed as $feed)
                  <b>{{ $feed->formatted_date }}</b>
                  <p>{{ $feed->content }} {{ $feed->entity_name }}</p>
                @endforeach
              </div>
            </div>

          </section><!--.box-typical-->
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
@endsection
