<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use App\Models\Score;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Choice::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $choice = Choice::create($request->all());

        return response()->json($choice, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Choice::find($id);
    }
    public function choice_list($question_id,$choice_id)
    {
        $question = Question ::findOrFail($question_id);
        $choice_list =$question-> choice_list;
        $choice_list->question_id= $question_id;
        $choice_list->choice->add(Choice::findOrFail($choice_id));
        $choice_list->save();
        return response(200);
    }

    public function answer_question($question_id,$choice_id,$user_id)
    {
        $points = Score::findOrFail($user_id);
        $question = Question ::findOrFail($question_id);
        $choice = Choice ::findOrFail($choice_id);
        $answer=$question->answer;
        $earning=$question->earning; 
        $score=$points->score;
        echo $earning;
        
        
        if ($answer == $choice_id)
        {
            $points->increment('score',+$earning);
        
            $points->save();
            return response(['message' => 'Bonne réponse votre score est: '
                                        .$score], 200);
            
        }else{
        
            return response(['message' => 'Mauvaise réponse',$score], 200);
        }
        


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
    public function update(Request $request, $id)
    {
        $choice = Choice::findOrFail($id);
        $choice->update($request->all());

        return response()->json($choice, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Choice::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
