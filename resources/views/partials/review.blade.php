<div class="col-lg-6 col-lg-push-3 col-md-12">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addreview">
    Add Review
  </button>
  <div class="modal" id="addreview" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Review for {{ $page->title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" role="form" method="POST" action="/users/{{ Auth::user()->id }} /b-reviews">
          <input type="hidden" name="page_id" value="{{ $page->id }}">
          <input type="text" name="title" value="Review for {{ $page->title }} by {{ Auth::user()->first_name }} {{Auth::user()->last_name}}"><br><br>

          <textarea type="text" name="content" placeholder="Write your review."></textarea><br><br>
          <p>Give rating between 1 and 5 for:</p>
          <label>Sustainability:
          <input type="number" min="0" max="5" name="rating_0"></label>
          <label>Reliability:
          <input type="number" min="0" max="5" name="rating_1"></label>
          <label>Value:
          <input type="number" min="0" max="5" name="rating_2"></label>
          <label>Outcome:
          <input type="number" min="0" max="5" name="rating_3"></label>

          <br><br>
              <button type="submit" class="btn">
                  Save Review
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
