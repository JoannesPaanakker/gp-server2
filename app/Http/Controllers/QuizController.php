<?php

namespace App\Http\Controllers;

use App\Page;
use App\Quiz;
use App\QuizAnswer;
use App\QuizQuestion;
use App\Update;
use App\User;

class QuizController extends Controller {

	// get quiz for pages
	public function getQuizPage() {
		$quiz = Quiz::where('id', 2)->with('categories.questions.answers')->get();
		return $quiz;
	}

	// get quiz for user
	public function getQuizUser() {
		$quiz = Quiz::where('id', 1)->with('categories.questions.answers')->get();
		return $quiz;
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
					// if this is the answer, 
					if ($possible_answer->id == $request['quiz_answers'][$question->id]) {
						// save it or update it, if it exists
						$answer = QuizAnswer::where('user_id', $user->id)->where('possible_answer_id', $possible_answer->id)->first();
						if(!$answer){
							$answer = new QuizAnswer;	
						}
						$answer->user_id = $user->id;
						$answer->question_text = $question->question;
						$answer->answer = $possible_answer->answer;
						$answer->possible_answer_id = $possible_answer;
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
		$page->quiz_completed = 1;
		$page->quiz_score = $request['quiz_score'];
		$page->quiz_comments = $request['quiz_comments'];
		$page->save();

		// save quiz answers
		QuizAnswer::where('page_id', $page->id)->delete(); //delete all previous answers for the user
		$questions = QuizQuestion::with('answers')->get();
		foreach ($questions as $question) {
			if (array_key_exists($question->id, $request['quiz_answers'])) {
				$answer_text = '';
				$answer_score = 0;
				foreach ($question->answers as $selected_answer) {
					if ($selected_answer->id == $request['quiz_answers'][$question->id]) {
						$answer_text = $selected_answer->answer;
						$answer_score = $selected_answer->score;
					}
				}
				$answer = new QuizAnswer;
				$answer->page_id = $page->id;
				$answer->question_text = $question->question;
				$answer->answer = $answer_text;
				$answer->score = $answer_score;
				$answer->save();
			}
		}

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
