<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use App\Models\Score;

use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Quiz::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    
    public function choose_quiz($user_id,$quiz_id){
        $user= User::findOrFail($user_id);
         $score= new Score;
        $score->user_id=$user->id;
    
        $quiz=Quiz::findOrFail($quiz_id);
        $score->quiz_id=$quiz->id; 
        
        $score->save(); 
        
        return $score->toArray();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quiz = Quiz::create($request->all());

        return response()->json($quiz, 201);
    }

    public function AddQuiz(Request $request){

        $quiz = Quiz::create($request->all());


        $Quiz = new Quiz();
        $Quiz->id=$quiz->id;
        $Quiz->label=$quiz->label;
        $Quiz->published=$quiz->published;

        $Question = new Question();
        $Question->id=$quiz->questions->id;
        $Question->label=$quiz->questions->label;
        $Question->answer=$quiz->questions->answer;
        $Question->earnings=$quiz->questions->earnings;
        $Question->quiz_id=$quiz->id;

        $Choice = new Choice();
        $Choice->id=$quiz->question->choices->id;
        $Choice->label=$quiz->question->choices->label;
        $Choice->question_id=$quiz->question->id;

        $Quiz->save();
        $Question->save();
        $Choice->save();

        return response(200);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Quiz::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editQuiz(Request $request, $quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $quiz->update($request->all());
        return response()->json($quiz, 200);
    }

    public function publish($quiz_id){
        $quiz = Quiz ::findOrFail($quiz_id);
        $quiz -> update(['published'=>1]);
        return response(['message' => 'Quiz Successfully published'], 200);
    }
    public function unpublish($quiz_id){
        $quiz = Quiz ::findOrFail($quiz_id);
        $quiz -> update(['published'=>0]);
        return response(['message' => 'Quiz unpblishde'], 200);;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($quiz_id){
        $quiz= Quiz::findOrFail($quiz_id);
        $quiz->delete();
        return response(['message' => 'Quiz deleted Successfully'], 200);
    }
    public function destroy($quiz_id)
    {
        $quiz= Quiz::findOrFail($quiz_id);
        $quiz->delete();
        return response(['message' => 'Deleted Successfully'], 200);
    }
}
