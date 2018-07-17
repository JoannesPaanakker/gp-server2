
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Follow {{ $user->first_name }} {{ $user->last_name }}
  </button>
  <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Follow {{ $user->first_name }} {{ $user->last_name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ Auth::user()->last_name }}
          <p>Are you sure you want to follow {{ $user->first_name }} {{ $user->last_name }}?</p>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/users/'.Auth::user()->id .'/follow-user-browser/'.$user->id) }}">
          <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <input type="hidden" name="">
              <button type="submit" class="btn btn-rounded">
                  Yes: I want to follow {{ $user->first_name }} {{ $user->last_name }}
              </button>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

