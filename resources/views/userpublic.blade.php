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
						@for($i = 0; $i < 290; $i = $i + 60)<img src="/img/feature-leaf.png" style="width:32px; display:inline-block; @if($user->quiz_score < $i) opacity:0.3 @endif">@endfor
						<div class="profile-card-name">{{ $user->first_name}} {{ $user->last_name}}</div>
						<!-- <button type="button" class="btn btn-rounded">Follow</button> -->
						<div id="share"></div>
					</div><!--.profile-card-->
					<div class="profile-statistic tbl">
						<div class="tbl-row">
							<div class="tbl-cell">
							</div>
							<div class="tbl-cell">
                Followers <b>{{ count($user->followed_by)}}</b>
							</div>
						</div>
					</div>
				</section><!--.box-typical-->
      </div><!--.col- -->
			<div class="col-lg-6 col-lg-push-3 col-md-6 col-sm-6">
        <section class="box-typical">
          <header class="box-typical-header-sm">Greenplatform member</header>
          <div class="p-a-md">
            <div class="tbl-cell">
            {{ $user->first_name}} {{ $user->last_name}} is a member of the Greenplatform. Please <a href="/">register</a> and/or <a href="/login">login</a> to view this profile.
            </div>
          </div>
        </section><!--.box-typical-->
      </div>
    </div>
  </div>
@endsection
