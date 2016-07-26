<?php

namespace App\Http\Controllers;

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
        QuizAnswer::where('user_id', $user->id)->delete(); //delete all previous answers for the user
        dd('ok');
        $questions = QuizQuestion::with('answers')->get();
        foreach ($questions as $question) {
            if (array_key_exists($question->id, $request['quiz_answers'])) {
                $answer_text = '';
                $answer_score = 0;
                foreach ($question->answers as $selected_answer) {
                    $answer_text = $selected_answer->answer;
                    $answer_score = $selected_answer->score;
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

    // get answers (quiz result) for a page
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

}
