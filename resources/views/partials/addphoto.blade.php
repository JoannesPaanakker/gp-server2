

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addphoto">
      Add Photo
    </button>
    <div class="modal" id="addphoto" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Photo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body extra">
            <form method="POST" action="/pages/{{ $page->id }}/images" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" name="userID" value="{{ Auth::user()->id }}">
              <input id="file" type="file" name="photo" accept="image/*" required="required" ></input>
              <button class="btn" type="submit">Add Photo</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
