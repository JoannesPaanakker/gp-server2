@extends('layouts.appuser')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h4 id="1000" class="ankor"> GPstandard Score: {{ $total_score }} for {{ $page->title }}</h4>
      <form role="form" method="POST" action="{{ url('/pages/'.$page->id.'/quiz-completed-browser') }}">
        <textarea type="text" name="quiz_comments" placeholder="Any comments or suggestions can be entered here."></textarea>
        <button type="submit" class="btn">
          Click here to save the score
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
                $number = 1
              @endphp
              @foreach($question['answers'] as $answer)
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/pages/'.$page->id.'/quiz-answer') }}">
                  <input type="hidden" name="answer" value="{{ $answer->answer }}">
                  <input type="hidden" name="score" value="{{ $answer->score }}">
                  <input type="hidden" name="qid" value="{{ $question->id }}">
                  <input type="hidden" name="q_text" value="{{ $question->question }}">
                  <button type="submit" class="answer n{{ $number }}">
                    {{ $answer->answer }}
                  </button>
                  @foreach($page_answers as $page_answer)
                    @if( $answer->answer == $page_answer->answer && $answer->question_id == $page_answer->question_id)
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
