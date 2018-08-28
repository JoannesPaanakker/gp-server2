  <button type="button" class="btn" data-toggle="modal" data-target="#addreview">
    Add Review
  </button>
  <div class="modal" id="addreview" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Write a review for {{ $page->title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body extra">
        <form class="form-horizontal" role="form" method="POST" action="/users/{{ Auth::user()->id }} /b-reviews" enctype="multipart/form-data">
          <input type="hidden" name="page_id" value="{{ $page->id }}">
          <p>Title:</p>
          <input class="tekst" type="text" name="title" Placeholder="Review for {{ $page->title }} by {{ Auth::user()->first_name }} {{Auth::user()->last_name}}"><br><br>
          <textarea class="tekst" type="text" name="content" placeholder="Write your review."></textarea><br><br>
          <p>Give rating between 1 and 5 for:</p>
          <div class="rating">
            <div>Sustainability:</div>
            <div>
              <input class="number" type="number" min="0" max="5" name="rating_0" value="5">
            </div>
          </div>
          <div class="rating">
            <div>Reliability:</div>
            <div>
              <input class="number" type="number" min="0" max="5" name="rating_1" value="5">
            </div>
          </div>
          <div class="rating">
            <div>Value:</div>
            <div>
              <input class="number" type="number" min="0" max="5" name="rating_2" value="5">
            </div>
          </div>
          <div class="rating">
            <div>Outcome:</div>
            <div>
              <input class="number" type="number" min="0" max="5" name="rating_3" value="5">
            </div>
          </div>
          <div class="rating">
            <label> Nominate for award? (0 = no, 1 = yes)
            <input class="number" type="number" min="0" max="1" name="prize_num" value="1"></label>
          </div>
          <br>
          <label for="file">Image upload</label>
          <input id="file" type="file" name="photo" accept="image/*" ></input>
          <br>
          <br>
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
<script>
    var uploadField = document.getElementById("file");
  uploadField.onchange = function() {
      if(this.files[0].size > 2097152){
         alert("File is too big, max 2MB!");
         this.value = "";
      };
  };
</script>
