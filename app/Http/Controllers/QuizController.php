<?php

namespace App\Http\Controllers;

use App\Page;
use App\Quiz;
use App\QuizAnswer;
use App\QuizQuestion;
use App\Update;
use App\User;

class QuizController extends Controller
{

    // get quiz for pages
    public function getQuizPage()
    {
        $quiz = Quiz::where('id', 2)->with('categories.questions.answers')->get();
        return $quiz;
    }

    // get quiz for user
    public function getQuizUser()
    {
        $quiz = Quiz::where('id', 1)->with('categories.questions.answers')->get();
        return $quiz;
    }

    // complete quiz
    public function completeQuizUser(User $user)
    {
        $request = request()->all();
        $user->quiz_completed = 1;
        $user->quiz_score = $request['quiz_score'];
        $user->save();

        // save quiz answers
        QuizAnswer::where('user_id', $user->id)->delete(); //delete all previous answers for the user
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
                $answer->user_id = $user->id;
                $answer->question_text = $question->question;
                $answer->answer = $answer_text;
                $answer->score = $answer_score;
                $answer->save();
            }
        }
        return response()->json(['status' => 'success']);
    }

    // complete quiz
    public function completeQuizPage(Page $page)
    {
        $request = request()->all();
        $page->quiz_completed = 1;
        $page->quiz_score = $request['quiz_score'];
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
        $update->content = 'Just completed the GP Standard quiz';
        $update->kind = 'page-update';
        $update->save();

        return response()->json(['status' => 'success']);
    }

    // get answers (quiz result) for a user
    public function getQuizAnswersUser(User $user)
    {
        $answers = QuizAnswer::where('user_id', $user->id)->get();
        $quiz = Quiz::where('id', 1)->get();
        $score = 0;
        foreach ($answers as $answer) {
            $score += $answer->score;
        }
        $percent = ceil($score * 100 / $quiz[0]->max_score);
        return ['answers' => $answers, 'score' => $score, 'percent' => $percent];
    }

    // get answers (quiz result) for a page
    public function getQuizAnswersPage(Page $page)
    {
        $answers = QuizAnswer::where('page_id', $page->id)->get();
        $quiz = Quiz::where('id', 2)->get();
        $score = 0;
        foreach ($answers as $answer) {
            $score += $answer->score;
        }
        $percent = ceil($score * 100 / $quiz[0]->max_score);
        return ['answers' => $answers, 'user_id' => $page->user_id, 'score' => $score, 'percent' => $percent];
    }

}
