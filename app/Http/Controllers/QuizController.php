<?php

namespace App\Http\Controllers;

use App\Page;
use App\Quiz;
use App\QuizAnswer;
use App\QuizQuestion;
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
        $questions = QuizQuestion::with('answers')->get();
        foreach ($questions as $question) {
            if (array_key_exists($question->id, $request['quiz_answers'])) {
                $answer_text = '';
                foreach ($question->answers as $selected_answer) {
                    $answer_text = $selected_answer->answer;
                }
                $answer = new QuizAnswer;
                $answer->user_id = $user->id;
                $answer->question_text = $question->question;
                $answer->answer = $answer_text;
                $answer->save();
            }
        }
        return response()->json(['status' => 'success']);
    }

    public function quizResultPage()
    {
        $questions = QuizQuestion::where('for_pages', 1)->with('answers')->get();
        return $questions;
    }

    public function quizResultUser()
    {
        $questions = QuizQuestion::where('for_users', 1)->with('answers')->get();
        return $questions;
    }

    // get answers (quiz result) for a page
    public function answers(Page $page)
    {
        $answers = $page->quizAnswers()->get();
        return $answers;
    }

}
