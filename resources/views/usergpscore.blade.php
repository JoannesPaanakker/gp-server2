@extends('layouts.appuser')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div id="1000" class="ankor">
      Green Plaform Score: {{ $total_score }} for {{ $user->last_name }}
      </div>
      <form role="form" method="POST" action="{{ url('/users/'.Auth::user()->id.'/quiz-completed-browser') }}">
        <input type="hidden" name="quiz_comments" value="Add a question">
        <button type="submit" class="btn">
          Save
        </button>
      </form>
      @foreach($quiz as $quiz)
        @php
          $qnumber = 1
        @endphp
        @foreach($quiz['categories'] as $category)
        <div>
          <h1>
            {{ $category->name }}
          </h1>
          @foreach($category['questions'] as $question)
            <div>
              <h4 id="{{ $question->id }}" class="ankor">
                {{ $qnumber }}. {{ $question->question }}
              </h4>
              @php
                $cc = 1
              @endphp
              @php
                $number = 1
              @endphp
              @foreach($question['answers'] as $answer)
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/users/'.Auth::user()->id.'/quiz-answer') }}">
                  <input type="hidden" name="answer" value="{{ $answer->answer }}">
                  <input type="hidden" name="score" value="{{ $answer->score }}">
                  <input type="hidden" name="qid" value="{{ $question->id }}">
                  <input type="hidden" name="q_text" value="{{ $question->question }}">
                  <button type="submit" class="answer n{{ $number }}">
                    {{ $answer->answer }}
                  </button>
                  @foreach($useranswers as $useranswer)
                    @if( $answer->answer == $useranswer->answer && $answer->question_id == $useranswer->question_id)
                      <i class="fa fa-check-circle"></i>  Current Answer
                    @endif
                  @endforeach

                </form>
                @php
                  $number++
                @endphp
              @endforeach
            </div>
            @php
              $qnumber++
            @endphp
          @endforeach
        </div>
        @endforeach
      @endforeach
    </div>
  </div>
</div>
@endsection
