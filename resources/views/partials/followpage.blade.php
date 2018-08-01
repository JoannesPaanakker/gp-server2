<section class="fix">
  <div class="col-lg-3 col-md-6 col-sm-6">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Follow {{ $page->title}}
    </button>
    <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Follow {{ $page->title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to follow this company?</p>
          </div>
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/users/'.Auth::user()->id .'/follow-page-browser/'.$page->id) }}">
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-rounded">
                    Yes: I want to follow {{ $page->title}}
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
  </div><!--.col- -->
</section>
