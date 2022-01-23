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
    public function choice_list($question_id)
    {

        $choice = Choice::where('question_id',$question_id)->get();

        return response(['choix'=>$choice],200);
    }

    public function answer_question($user_id,$question_id,$choice_id)
    {
        $points = Score::find($user_id);
        $question = Question ::findOrFail($question_id);
        //$choice = Choice ::findOrFail($choice_id);
        $answer=$question->answer;
        $earning=$question->earning; 
        $score=$points->score;
        
        
        
        if ($answer == $choice_id)
        {
    
           $points->increment('score',$earning);
          
            $points->save();
            return response(['message' => 'Bonne réponse votre score est: '
                                        .$points->score], 200);
                                        echo $points;
            
        }else{
        
            
            return response(['message' => 'Mauvaise réponse',$score], 200);
        }
        
        $points->save();

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
