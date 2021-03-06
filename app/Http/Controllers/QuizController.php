<?php

namespace App\Http\Controllers;

use App\Page;
use App\Quiz;
use App\QuizAnswer;
use App\QuizQuestion;
use App\Update;
use App\User;
use Auth;
use Illuminate\Http\Request;

class QuizController extends Controller {

  // get quiz for pages
  public function getQuizPage() {
    $quiz = Quiz::where('id', 2)->with('categories.questions.answers')->get();
    return $quiz;
  }
  // get quiz for pages Browser
  public function getQuizPageB(Page $page) {
    $quiz = Quiz::where('id', 2)->with('categories.questions.answers')->get();
    $page_answers = QuizAnswer::where('page_id', $page->id)->get();
    // calculate score
    $total_score = 0;
    foreach($page_answers as $answer){
      $total_score += $answer->score;
    }
    return view('pagegpscore', compact('page', 'quiz', 'page_answers', 'total_score'));
  }

  // save quiz answer from browser for page
  public function saveQuizAnswerPage(Page $page) {
    $request = request()->all();
    $qid = $request['qid'];
    $answer = QuizAnswer::where('page_id', $page->id)->where('question_id', $qid)->first();
    if(!$answer){
      $answer = new QuizAnswer;
    }
    $answer->page_id = $page->id;
    $answer->question_text = $request['q_text'];
    $answer->answer = $request['answer'];
    $answer->question_id = $qid;
    $answer->score = $request['score'];
    $answer->save();
    $qid++;
    // set anchor for last question:
    $question = QuizQuestion::where('id', $qid)->first();
    if(!$question){
      $qid = 1000;
    }
    return redirect('/pages/'.$page->id.'/quizpage#'.$qid);
  }

  // complete page quiz from browser
  public function completeQuizPageFromBrowser(User $user, Page $page) {
    $request = request()->all();
    // calculate score from all stored answers
    $answers = QuizAnswer::where('page_id', $page->id)->get();
    $total_score = 0;
    foreach($answers as $answer){
      $total_score += $answer->score;
    }

    $page->quiz_completed = 1;
    $page->quiz_score = $total_score;
    $page->quiz_comments = $request['quiz_comments'];
    $page->save();
    // post update
    $update = new Update;
    $update->page_id = $page->id;
    $update->user_id = Auth::user()->id;
    $update->content = 'Just completed the GreenPlatform Standard quiz';
    $update->kind = 'quiz-completed';
    $update->entity_id = $page->id;
    $update->entity_name = $page->title;
    $update->save();
    return redirect('/page/' . $page->slug . '/' . $page->id);
  }

	// get quiz for user
	public function getQuizUser() {
		$quiz = Quiz::where('id', 1)->with('categories.questions.answers')->get();
		return $quiz;
	}

  // get quiz for browser user
  public function getQuizUserPage(User $user) {
    $quiz = Quiz::where('id', 1)->with('categories.questions.answers')->get();
    $useranswers = QuizAnswer::where('user_id', $user->id)->get();

    // calculate score
    $total_score = 0;
    foreach($useranswers as $answer){
      $total_score += $answer->score;
    }
    return view('usergpscore', compact('quiz', 'useranswers', 'total_score', 'user'));
  }

  // save quiz answer from browser for user

  public function saveQuizAnswer(User $user) {
    $request = request()->all();
    $qid = $request['qid'];
    $answer = QuizAnswer::where('user_id', $user->id)->where('question_id', $qid)->first();
    if(!$answer){
      $answer = new QuizAnswer;
    }
    $answer->user_id = $user->id;
    $answer->question_text = $request['q_text'];
    $answer->answer = $request['answer'];
    $answer->question_id = $qid;
    $answer->score = $request['score'];
    $answer->save();
    $qid++;
    // set anchor for last question:
    $question = QuizQuestion::where('id', $qid)->first();
    if(!$question){
      $qid = 1000;
    }
    return redirect('/users/'.$user->id.'/quizpage#'.$qid);
  }
  // complete quiz from browser


public function completeQuizUserFromBrowser(User $user) {
    $request = request()->all();

    // calculate score from all stored answers

    $answers = QuizAnswer::where('user_id', $user->id)->get();
    $total_score = 0;
    foreach($answers as $answer){
      $total_score += $answer->score;
    }

    $user->quiz_completed = 1;
    $user->quiz_score = $total_score;
    $user->quiz_comments = $request['quiz_comments'];
    $user->save();


    // post update
    $update = new Update;
    $update->user_id = $user->id;
    $update->content = 'Just completed the GP Standard quiz';
    $update->kind = 'quiz-completed';
    $update->entity_id = $user->id;
    $update->entity_name = $user->first_name + $user->last_name;
    $update->save();

    return redirect('/user/'.$user->id);
  }





	// complete quiz
	public function completeQuizUser(User $user) {
		$request = request()->all();

		// save quiz answers

		//QuizAnswer::where('user_id', $user->id)->delete(); //delete all previous answers for the user

		$questions = QuizQuestion::with('answers')->get();
		foreach ($questions as $question) {
			// if the question was answered,
			if (array_key_exists($question->id, $request['quiz_answers'])) {
				// loop through all the possible answers
				foreach ($question->answers as $possible_answer) {
					// check if the question was skipped
					if($request['quiz_answers'][$question->id] == 'skipped'){
						//dd('skipped');
					}

					// if this is the answer,
					if ($possible_answer->id == $request['quiz_answers'][$question->id]) {
						// save it or update it, if it exists
						$answer = QuizAnswer::where('user_id', $user->id)->where('question_id', $question->id)->first();
						if(!$answer){
							$answer = new QuizAnswer;
						}
						$answer->user_id = $user->id;
						$answer->question_text = $question->question;
						$answer->answer = $possible_answer->answer;
						$answer->question_id = $question->id;
						$answer->score = $possible_answer->score;
						$answer->save();
					}
				}
			}
		}

		// calculate score from all stored answers
		$answers = QuizAnswer::where('user_id', $user->id)->get();
		$total_score = 0;
		foreach($answers as $answer){
			$total_score += $answer->score;
		}

		$user->quiz_completed = 1;
		$user->quiz_score = $total_score;
		$user->quiz_comments = $request['quiz_comments'];
		$user->save();


		// post update
		$update = new Update;
		$update->user_id = $user->id;
		$update->content = 'Just completed the GP Standard quiz';
		$update->kind = 'quiz-completed';
		$update->entity_id = $user->id;
		$update->entity_name = '';
		$update->save();

		return response()->json(['status' => 'success']);

	}

	// complete quiz
	public function completeQuizPage(Page $page) {
		$request = request()->all();

		// save quiz answers
		//QuizAnswer::where('page_id', $page->id)->delete(); //delete all previous answers for the user
		$questions = QuizQuestion::with('answers')->get();
		foreach ($questions as $question) {
			// if the question was answered,
			if (array_key_exists($question->id, $request['quiz_answers'])) {
				// loop through all the possible answers
				foreach ($question->answers as $possible_answer) {
					// check if the question was skipped
					if($request['quiz_answers'][$question->id] == 'skipped'){
						//dd('skipped');
					}

					// if this is the answer,
					if ($possible_answer->id == $request['quiz_answers'][$question->id]) {
						// save it or update it, if it exists
						$answer = QuizAnswer::where('page_id', $page->id)->where('question_id', $question->id)->first();
						if(!$answer){
							$answer = new QuizAnswer;
						}
						$answer->page_id = $page->id;
						$answer->question_text = $question->question;
						$answer->answer = $possible_answer->answer;
						$answer->question_id = $question->id;
						$answer->score = $possible_answer->score;
						$answer->save();
					}
				}
			}
		}

		// calculate score from all stored answers
		$answers = QuizAnswer::where('page_id', $page->id)->get();
		$total_score = 0;
		foreach($answers as $answer){
			$total_score += $answer->score;
		}

		$page->quiz_completed = 1;
		$page->quiz_score = $total_score;
		$page->quiz_comments = $request['quiz_comments'];
		$page->save();

		// post an update
		$update = new Update;
		$update->page_id = $page->id;
		$update->user_id = $page->user_id;
		$update->content = '';
		$update->kind = 'quiz-completed-page';
		$update->entity_id = $page->id;
		$update->entity_name = $page->title;
		$update->save();

		return response()->json(['status' => 'success']);
	}

	// get answers (quiz result) for a user
	public function getQuizAnswersUser(User $user) {
		$answers = QuizAnswer::where('user_id', $user->id)->get();
		$quiz = Quiz::where('id', 1)->get();
		$score = 0;
		foreach ($answers as $answer) {
			$score += $answer->score;
		}
		$percent = ceil($score * 100 / $quiz[0]->max_score);
		return ['answers' => $answers, 'quiz_comments' => $user->quiz_comments, 'score' => $score, 'percent' => $percent];
	}

	// get answers (quiz result) for a page
	public function getQuizAnswersPage(Page $page) {
		$answers = QuizAnswer::where('page_id', $page->id)->get();
		$quiz = Quiz::where('id', 2)->get();
		$score = 0;
		foreach ($answers as $answer) {
			$score += $answer->score;
		}
		$percent = ceil($score * 100 / $quiz[0]->max_score);
		return ['answers' => $answers, 'quiz_comments' => $page->quiz_comments, 'user_id' => $page->user_id, 'score' => $score, 'percent' => $percent];
	}

}
