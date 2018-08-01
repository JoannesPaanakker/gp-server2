<div class="col-lg-3 col-md-6 col-sm-6">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addgoal">
    New Goal
  </button>
  <div class="modal" id="addgoal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Goal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body extra">
        <form class="form-horizontal" role="form" method="POST" action="/users/{{ Auth::user()->id }} /b-goals">
          <input type="text" name="title" placeholder="Title"><br><br>
          <textarea class="tekst" type="text" name="content" placeholder="Goal description"></textarea><br><br>
          <input type="number" min="0" max="100" name="progress" placeholder="Number between 0 and 100"><br><br>
              <button type="submit" class="btn btn-rounded">
                  Save Goal
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
