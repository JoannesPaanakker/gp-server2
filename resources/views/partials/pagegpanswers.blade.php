
  <button type="button" class="btn" data-toggle="modal" data-target="#quizanswers">
    GPstandard
  </button>
  <div class="modal" id="quizanswers" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page->title}}'s GP Quiz Answers.</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @if(count($page->quizAnswers)>0)
            @foreach($page->quizAnswers as $answer)
              <div class="p-x-md">
                <b>{{ $answer->question_text }}</b>
                <p>{{ $answer->answer }}</p>
              </div>
            @endforeach
          @else
            <div class="p-a-md">
              This company didn't complete the GreenPlatform Standard quiz yet.
            </div>
          @endif
          <a href="/pages/{{ $page->id }}/quizpage" class="btn">GreenPlatform Quiz</a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

