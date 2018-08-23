<div class="col-lg-3 col-md-6 col-sm-6">
  <button type="button" class="btn" data-toggle="modal" data-target="#addtip">
    New Tip
  </button>
  <div class="modal" id="addtip" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New tip</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body extra">
        <form class="form-horizontal" role="form" method="POST" action="/b-tips">

          <input type="hidden" name="userID" value="{{ Auth::user()->id }}">
          <input type="text" name="title" placeholder="Title"><br><br>
          <textarea class="tekst" type="text" name="content">Tip description</textarea><br><br>
              <button type="submit" class="btn btn-rounded">
                  Save tip
              </button>

        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div><!--.col- -->
