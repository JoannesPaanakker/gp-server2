  <button type="button" class="btn" data-toggle="modal" data-target="#followers">
    Followers
  </button>
  <div class="modal" id="followers" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">People following {{ $page->title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body extra">
            <div class="p-a-md">
        @if(count($page->followed) > 0)
          @foreach($page->followed as $user)
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
              <h5>
                <a href="/user/{{ $user->slug }}/{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</a>
              </h5>
            </div>
            <br>
          @endforeach
            </div>
        @else
          <div class="p-a-md">
            This page is not followed by any people yet.
          </div>
        @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
