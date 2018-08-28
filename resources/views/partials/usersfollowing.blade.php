<section class="box-typical">
  <header class="box-typical-header-sm">
    People followed by {{ $user->first_name}} {{ $user->last_name}}
  </header>
      <div class="p-a-md">
  @if(count($user->following_users) > 0)
    @foreach($user->following_users as $user)
        <div class="user-card-row">

            <div class="tbl-cell tbl-cell-photo">
              <a href="/user/{{ $user->slug }}/{{ $user->id }}">
                @if($user->picture)
                  <img class="avatar" src="{{ $user->picture }}" alt="profile image">
                @else
                  <img class="avatar" src="/img/avatar-sign.png" alt="profile image"/>
                @endif
              </a>
            </div>
          <h5><a href="/user/{{ $user->slug }}/{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</a></h5>
        </div>
        <br>
    @endforeach
      </div>

  @else
    <div class="p-a-md">
      This user is not following any people yet.
    </div>
  @endif
</section>
