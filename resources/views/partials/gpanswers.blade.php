<div class="col-lg-3 col-md-6 col-sm-6">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#quizanswers">
    Quiz Answers
  </button>
  <div class="modal" id="quizanswers" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $user->first_name}} {{ $user->last_name}}'s GP Quiz Answers.</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to follow this company?</p>
          <header class="box-typical-header-sm">
            GP Standard
          </header>
          @if(count($user->quiz_answers)>0)

            @foreach($user->quiz_answers as $answer)

              <div class="p-x-md">

                <b>{{ $answer->question_text }}</b>
                <p>{{ $answer->answer }}</p>

              </div>

            @endforeach

          @else
            <div class="p-a-md">
              This user didn't complete the GP Standard quiz yet.
            </div>
          @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div><!--.col- -->
