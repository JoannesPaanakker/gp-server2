@extends('layouts.appcompany')

@section('content')

<!-- <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.0&appId=249311135651669';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="fb-login-button" data-width="80" data-max-rows="1" data-size="small" data-button-type="login_with" data-show-faces="true" data-auto-logout-link="true" data-use-continue-as="true"></div>


<fb:login-button
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>

<script>

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
FB.login(function(response){
  if (response.status === 'connected') {
    // Logged into your app and Facebook.
  } else {
    // The person is not logged into this app or we are unable to tell.
  }
});
</script> -->

<a href="/fbredirect">
<button type="button" class="btn">FB login</button>
</a>


<section class="box-typical">
  <div class="p-a-md">
    <b>About</b>
    <input type="hidden" id="pageid" value="{{ $page->id }}">
    <div class="text-block text-block-typical" id="textabout">
      <input type="hidden" id="txt_about_org" value="{{ $page->about }}">
      {{ $page->about }}
      <button type="button" id="editabout" class="btn btn-rounded">Edit</button>
    </div>
  </div>
</section>
<section class="box-typical">
  <div class="p-a-md">
    <b>Categories</b>
    <div class="profile-interests" id="textcategories" style="margin-top:30px">
      <input type="hidden" id="txt_categories_org" value="{{ $page->categories }}">
      @foreach(explode(',',$page->categories) as $category)
        <a href="#" class="label label-light-grey">{{ $category }}</a>
      @endforeach
      <button type="button" id="editcat" class="btn btn-rounded">Edit</button>
      <button type="button" id="showcats" class="btn btn-rounded">Cats</button>
    </div>
  </div>
</section>
<section class="box-typical">
  <div class="p-a-md">
    <b>Cats</b>
    <div class="profile-interests" style="margin-top:30px">
      <p id="cats">

      </p>
    </div>
  </div>
</section>
<section class="box-typical">
  <div class="p-a-md">
    <b>Cats II</b>
    <div class="profile-interests" style="margin-top:30px">
      <p id="cats2">

      </p>
    </div>
  </div>
</section>
<section class="box-typical">
  <div class="p-a-md">
    <b>Photo's</b>
    <form method="POST" action="/pages/{{ $page->id }}/update" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name="about" value="{{ $page->about }}">{{ $page->about }}</input>
      <input type="file" name="photo"></input>
      <button type="submit">Save Image</button>
    </form>
  </div>
</section>
<section class="box-typical">
  <div class="p-a-md">
    <b>Photo II</b>
    <form method="POST" action="/pages/{{ $page->id }}/images" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="file" name="photo"></input>
      <button type="submit">Save Image</button>
    </form>
  </div>
</section>
<script>


</script>
@endsection
